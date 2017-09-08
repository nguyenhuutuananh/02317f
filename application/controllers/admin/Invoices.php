<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Invoices extends Admin_controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('invoices_model');
    }
    /* Get all invoices in case user go on index page */
    public function index($id = false)
    {
        $this->list_invoices($id);
    }
    /* List all invoices datatables */
    public function list_invoices($id = false, $clientid = false)
    {

        if (!has_permission('invoices', '', 'view') && !has_permission('invoices', '', 'view_own')) {
            access_denied('invoices');
        }
        $this->load->model('payment_modes_model');
        $data['payment_modes'] = $this->payment_modes_model->get('', array(), true);
        if ($this->input->is_ajax_request()) {
            $this->perfex_base->get_table_data('invoices', array(
                'id' => $id,
                'clientid' => $clientid,
                'data' => $data
            ));
        }
        $data['invoiceid'] = '';
        if (is_numeric($id)) {
            $data['invoiceid'] = $id;
        }
        $data['title']                = _l('invoices');
        $data['invoices_years']       = $this->invoices_model->get_invoices_years();
        $data['invoices_sale_agents'] = $this->invoices_model->get_sale_agents();
        $data['invoices_statuses']    = $this->invoices_model->get_statuses();
        $data['bodyclass']            = 'invoices_total_manual';
        $this->load->view('admin/invoices/manage', $data);
    }
    public function client_change_data($customer_id, $current_invoice = 'undefined')
    {
        if ($this->input->is_ajax_request()) {
            $this->load->model('projects_model');
            $data                     = array();
            $data['billing_shipping'] = $this->clients_model->get_customer_billing_and_shipping_details($customer_id);
            $data['client_currency']  = $this->clients_model->get_customer_default_currency($customer_id);

            $where_projects = 'clientid=' . $customer_id;

            if (!has_permission('projects', '', 'view')) {
                $where_projects .= ' AND id IN (SELECT project_id FROM tblprojectmembers WHERE staff_id=' . get_staff_user_id() . ')';
            }

            $data['projects']           = $this->projects_model->get('', $where_projects);
            $data['billable_tasks']     = $this->tasks_model->get_billable_tasks($customer_id);
            $_data['invoices_to_merge'] = $this->invoices_model->check_for_merge_invoice($customer_id, $current_invoice);
            $data['merge_info']         = $this->load->view('admin/invoices/merge_invoice', $_data, true);

            $this->load->model('currencies_model');
            $__data['expenses_to_bill'] = $this->invoices_model->get_expenses_to_bill($customer_id);
            $data['expenses_bill_info'] = $this->load->view('admin/invoices/bill_expenses', $__data, true);
            echo json_encode($data);
        }
    }
    public function update_number_settings($id)
    {
        $response = array(
            'success' => false,
            'message' => ''
        );
        if ($this->input->post('prefix')) {
            $affected_rows = 0;

            $this->db->where('id', $id);
            $this->db->update('tblinvoices', array(
                'prefix' => $this->input->post('prefix')
            ));
            if ($this->db->affected_rows() > 0) {
                $affected_rows++;
            }

            if ($affected_rows > 0) {
                $response['success'] = true;
                $response['message'] = _l('updated_successfuly', _l('invoice'));
            }
        }
        echo json_encode($response);
        die;
    }
    public function validate_invoice_number()
    {
        $isedit          = $this->input->post('isedit');
        $number          = $this->input->post('number');
        $date            = $this->input->post('date');
        $original_number = $this->input->post('original_number');
        $number          = trim($number);
        $number          = ltrim($number, '0');
        if ($isedit == 'true') {
            if ($number == $original_number) {
                echo json_encode(true);
                die;
            }
        }
        if (total_rows('tblinvoices', array(
            'YEAR(date)' => date('Y', strtotime(to_sql_date($date))),
            'number' => $number
        )) > 0) {
            echo 'false';
        } else {
            echo 'true';
        }
    }
    public function mark_as_cancelled($id)
    {
        if (!has_permission('invoices', '', 'edit') && !has_permission('invoices', '', 'create')) {
            access_denied('invoices');
        }
        $success = $this->invoices_model->mark_as_cancelled($id);
        if ($success) {
            set_alert('success', _l('invoice_marked_as_cancelled_successfuly'));
        }
        redirect(admin_url('invoices/list_invoices/' . $id));
    }
    public function unmark_as_cancelled($id)
    {
        if (!has_permission('invoices', '', 'edit') && !has_permission('invoices', '', 'create')) {
            access_denied('invoices');
        }
        $success = $this->invoices_model->unmark_as_cancelled($id);
        if ($success) {
            set_alert('success', _l('invoice_unmarked_as_cancelled'));
        }
        redirect(admin_url('invoices/list_invoices/' . $id));
    }
    public function copy($id)
    {
        if (!$id) {
            redirect(admin_url('invoices'));
        }
        if (!has_permission('invoices', '', 'create')) {
            access_denied('invoices');
        }
        $new_id = $this->invoices_model->copy($id);
        if ($new_id) {
            set_alert('success', _l('invoice_copy_success'));
            redirect(admin_url('invoices/invoice/' . $new_id));
        } else {
            set_alert('success', _l('invoice_copy_fail'));
        }
        redirect(admin_url('invoices/invoice/' . $id));
    }
    public function get_items_suggestions()
    {
        $this->load->model('invoice_items_model');
        echo json_encode($this->invoice_items_model->get());
    }
    public function get_merge_data($id)
    {
        $invoice = $this->invoices_model->get($id);
        $i       = 0;
        foreach ($invoice->items as $item) {
            $invoice->items[$i]['taxname']          = get_invoice_item_taxes($item['id']);
            $invoice->items[$i]['long_description'] = clear_textarea_breaks($item['long_description']);
            $this->db->where('item_id', $item['id']);
            $rel              = $this->db->get('tblitemsrelated')->result_array();
            $item_related_val = '';
            $rel_type         = '';
            foreach ($rel as $item_related) {
                $rel_type = $item_related['rel_type'];
                $item_related_val .= $item_related['rel_id'] . ',';
            }
            if ($item_related_val != '') {
                $item_related_val = substr($item_related_val, 0, -1);
            }
            $invoice->items[$i]['item_related_formated_for_input'] = $item_related_val;
            $invoice->items[$i]['rel_type']                        = $rel_type;
            $i++;
        }
        echo json_encode($invoice);
    }
    public function get_bill_expense_data($id)
    {
        $this->load->model('expenses_model');
        $expense = $this->expenses_model->get($id);

        $expense->qty              = 1;
        $expense->long_description = clear_textarea_breaks($expense->description);
        $expense->description      = $expense->name;
        $expense->rate             = $expense->amount;
        if ($expense->tax != 0) {
            $expense->taxname = $expense->tax_name . '|' . $expense->taxrate;
        }
        echo json_encode($expense);
    }
    /* Add new invoice or update existing */
    public function invoice($id = '')
    {
        if (!has_permission('invoices', '', 'view') && !has_permission('invoices', '', 'view_own')) {
            access_denied('invoices');
        }
        if ($this->input->post()) {
            $invoice_data = $this->input->post(NULL, FALSE);
            if ($id == '') {
                if (!has_permission('invoices', '', 'create')) {
                    access_denied('invoices');
                }
                $id = $this->invoices_model->add($invoice_data);
                if ($id) {
                    set_alert('success', _l('added_successfuly', _l('invoice')));
                    redirect(admin_url('invoices/list_invoices/' . $id));
                }
            } else {
                if (!has_permission('invoices', '', 'edit')) {
                    access_denied('invoices');
                }
                $success = $this->invoices_model->update($invoice_data, $id);
                if ($success) {
                    set_alert('success', _l('updated_successfuly', _l('invoice')));
                }
                redirect(admin_url('invoices/list_invoices/' . $id));
            }
        }
        if ($id == '') {
            $title                  = _l('create_new_invoice');
            $data['billable_tasks'] = array();
        } else {
            $invoice = $this->invoices_model->get($id);

            if (!$invoice || (!has_permission('invoices', '', 'view') && $invoice->addedfrom != get_staff_user_id())) {
                blank_page(_l('invoice_not_found'), 'danger');
            }

            $data['invoices_to_merge']          = $this->invoices_model->check_for_merge_invoice($invoice->clientid, $invoice->id);
            $data['expenses_to_bill']           = $this->invoices_model->get_expenses_to_bill($invoice->clientid);
            $data['invoice_recurring_invoices'] = $this->invoices_model->get_invoice_recuring_invoices($id);

            $data['invoice']        = $invoice;
            $data['edit']           = true;
            $data['billable_tasks'] = $this->tasks_model->get_billable_tasks($invoice->clientid);
            $title                  = _l('edit', _l('invoice_lowercase')) . ' - ' . format_invoice_number($invoice->id);
        }
        if ($this->input->get('customer_id')) {
            $data['customer_id']        = $this->input->get('customer_id');
            $data['do_not_auto_toggle'] = true;
        }

        $this->load->model('payment_modes_model');
        $data['payment_modes'] = $this->payment_modes_model->get('', array(
            'expenses_only !=' => 1
        ));
        $this->load->model('taxes_model');
        $data['taxes'] = $this->taxes_model->get();
        $this->load->model('invoice_items_model');
        $data['items']        = $this->invoice_items_model->get_grouped();
        $data['items_groups'] = $this->invoice_items_model->get_groups();

        $this->load->model('currencies_model');
        $data['currencies'] = $this->currencies_model->get();

        $where_clients = 'tblclients.active=1';

        if (!has_permission('customers', '', 'view')) {
            $where_clients .= ' AND tblclients.userid IN (SELECT customer_id FROM tblcustomeradmins WHERE staff_id=' . get_staff_user_id() . ')';
        }

        $data['clients'] = $this->clients_model->get('', $where_clients);
        if ($id != '') {
            if (total_rows('tblclients', array(
                'active' => 0,
                'userid' => $data['invoice']->clientid
            )) > 0 || (total_rows('tblcustomeradmins', array(
                'staff_id' => get_staff_user_id(),
                'customer_id' => $data['invoice']->clientid
            )) == 0 && !has_permission('customers', '', 'view'))) {
                $data['clients'][] = $this->clients_model->get($data['invoice']->clientid, array(), 'row_array');
            }
        }

        $data['projects'] = array();
        if ($id != '' || isset($data['customer_id'])) {

            $where             = '';
            $where_customer_id = (isset($data['customer_id']) ? $data['customer_id'] : $invoice->clientid);
            $where .= 'clientid=' . $where_customer_id;

            if (!has_permission('projects', '', 'view')) {
                $where .= ' AND id IN (SELECT project_id FROM tblprojectmembers WHERE staff_id=' . get_staff_user_id() . ')';
            }

            $data['projects'] = $this->projects_model->get('', $where);

            if ($id != '' && $data['invoice']->project_id != 0) {
                if (total_rows('tblprojectmembers', array(
                    'staff_id' => get_staff_user_id(),
                    'project_id' => $data['invoice']->project_id
                )) == 0 && !has_permission('projects', '', 'view')) {
                    $this->db->where('id', $data['invoice']->project_id);
                    $data['projects'][] = $this->db->get('tblprojects')->row_array();
                }
            }
        }

        $data['staff']             = $this->staff_model->get('', 1);
        $data['title']             = $title;
        $data['bodyclass']         = 'invoice';
        $data['accounting_assets'] = true;
        $this->load->view('admin/invoices/invoice', $data);
    }
    /* Get all invoice data used when user click on invoiec number in a datatable left side*/
    public function get_invoice_data_ajax($id)
    {
        if (!has_permission('invoices', '', 'view') && !has_permission('invoices', '', 'view_own')) {
            echo _l('access_denied');
            die;
        }
        if (!$id) {
            die('No invoice found');
        }
        $invoice = $this->invoices_model->get($id);

        if (!$invoice || (!has_permission('invoices', '', 'view') && $invoice->addedfrom != get_staff_user_id())) {
            echo _l('invoice_not_found');
            die;
        }
        $invoice->date    = _d($invoice->date);
        $invoice->duedate = _d($invoice->duedate);
        $template_name    = 'invoice-send-to-client';
        if ($invoice->sent == 1) {
            $template_name = 'invoice-already-send';
        }

        $template_name = do_action('after_invoice_sent_template_statement', $template_name);

        $contact = $this->clients_model->get_contact(get_primary_contact_user_id($invoice->clientid));
        $email   = '';
        if ($contact) {
            $email = $contact->email;
        }

        $data['template'] = get_email_template_for_sending($template_name, $email);

        $data['invoices_to_merge'] = $this->invoices_model->check_for_merge_invoice($invoice->clientid, $id);
        $data['template_name']     = $template_name;
        // Check for recorded payments
        $this->load->model('payments_model');
        $data['members']  = $this->staff_model->get('', 1);
        $data['contacts'] = $this->clients_model->get_contacts($invoice->clientid);
        $data['payments'] = $this->payments_model->get_invoice_payments($id);
        $data['activity'] = $this->invoices_model->get_invoice_activity($id);

        $data['invoice_recurring_invoices'] = $this->invoices_model->get_invoice_recuring_invoices($id);

        $data['invoice'] = $invoice;
        $this->load->view('admin/invoices/invoice_preview_template', $data);
    }
    public function get_invoices_total()
    {
        if ($this->input->post()) {
            load_invoices_total_template();
        }
    }
    /* Record new inoice payment view */
    public function record_invoice_payment_ajax($id)
    {
        $this->load->model('payment_modes_model');
        $this->load->model('payments_model');
        $data['payment_modes'] = $this->payment_modes_model->get('', array(
            'expenses_only !=' => 1
        ));
        $data['invoice']       = $invoice = $this->invoices_model->get($id);
        $data['payments']      = $this->payments_model->get_invoice_payments($id);
        $this->load->view('admin/invoices/record_payment_template', $data);
    }
    /* This is where invoice payment record $_POST data is send */
    public function record_payment()
    {
        if (!has_permission('payments', '', 'create')) {
            access_denied('Record Payment');
        }
        if ($this->input->post()) {
            $this->load->model('payments_model');
            $id = $this->payments_model->process_payment($this->input->post(), '');
            if ($id) {
                set_alert('success', _l('invoice_payment_recorded'));
                redirect(admin_url('payments/payment/' . $id));
            } else {
                set_alert('danger', _l('invoice_payment_record_failed'));
            }
            redirect(admin_url('invoices/list_invoices/' . $this->input->post('invoiceid')));
        }
    }
    /* Send invoiece to email */
    public function send_to_email($id)
    {
        if (!has_permission('invoices', '', 'view') && !has_permission('invoices', '', 'view_own')) {
            access_denied('invoices');
        }
        $success = $this->invoices_model->send_invoice_to_client($id, '', $this->input->post('attach_pdf'), $this->input->post('cc'));
        // In case client use another language
        load_admin_language();
        if ($success) {
            set_alert('success', _l('invoice_sent_to_client_success'));
        } else {
            set_alert('danger', _l('invoice_sent_to_client_fail'));
        }
        redirect(admin_url('invoices/list_invoices/' . $id));
    }
    /* Delete invoice payment*/
    public function delete_payment($id, $invoiceid)
    {
        if (!has_permission('payments', '', 'delete')) {
            access_denied('payments');
        }
        $this->load->model('payments_model');
        if (!$id) {
            redirect(admin_url('payments'));
        }
        $response = $this->payments_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('payment')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('payment_lowercase')));
        }
        redirect(admin_url('invoices/list_invoices/' . $invoiceid));
    }
    /* Delete invoice */
    public function delete($id)
    {
        if (!has_permission('invoices', '', 'delete')) {
            access_denied('invoices');
        }
        if (!$id) {
            redirect(admin_url('invoices/list_invoices'));
        }
        $success = $this->invoices_model->delete($id);

        if ($success) {
            set_alert('success', _l('deleted', _l('invoice')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('invoice_lowercase')));
        }
        if (strpos($_SERVER['HTTP_REFERER'], 'list_invoices') !== false) {
            redirect(admin_url('invoices/list_invoices'));
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function delete_attachment($id)
    {
        $file = $this->misc_model->get_file($id);
        if ($file->staffid == get_staff_user_id() || is_admin()) {
            echo $this->invoices_model->delete_attachment($id);
        } else {
            header('HTTP/1.0 400 Bad error');
            echo _l('access_denied');
            die;
        }
    }
    /* Will send overdue notice to client */
    public function send_overdue_notice($id)
    {
        if (!has_permission('invoices', '', 'view') && !has_permission('invoices', '', 'view_own')) {
            access_denied('invoices');
        }
        $send = $this->invoices_model->send_invoice_overdue_notice($id);
        if ($send) {
            set_alert('success', _l('invoice_overdue_reminder_sent'));
        } else {
            set_alert('warning', _l('invoice_reminder_send_problem'));
        }
        redirect(admin_url('invoices/list_invoices/' . $id));
    }
    /* Generates invoice PDF and senting to email of $send_to_email = true is passed */
    public function pdf($id)
    {
        if (!has_permission('invoices', '', 'view') && !has_permission('invoices', '', 'view_own')) {
            access_denied('invoices');
        }
        if (!$id) {
            redirect(admin_url('invoices/list_invoices'));
        }
        $invoice        = $this->invoices_model->get($id);
        $invoice_number = format_invoice_number($invoice->id);
        $pdf            = invoice_pdf($invoice);
        $type           = 'D';
        if ($this->input->get('print')) {
            $type = 'I';
        }
        $pdf->Output(mb_strtoupper(slug_it($invoice_number)) . '.pdf', $type);
    }

    public function mark_as_sent($id)
    {
        if (!$id) {
            redirect(admin_url('invoices/list_invoices'));
        }
        $success = $this->invoices_model->set_invoice_sent($id, true);
        if ($success) {
            set_alert('success', _l('invoice_marked_as_sent'));
        } else {
            set_alert('warning', _l('invoice_marked_as_sent_failed'));
        }
        redirect(admin_url('invoices/list_invoices/' . $id));
    }
    public function get_due_date()
    {
        if ($this->input->post()) {
            $date    = $this->input->post('date');
            $duedate = '';
            if (get_option('invoice_due_after') != 0) {
                $date    = to_sql_date($date);
                $d       = date('Y-m-d', strtotime('+' . get_option('invoice_due_after') . ' DAY', strtotime($date)));
                $duedate = _d($d);
            }
            echo $duedate;
        }
    }
}
