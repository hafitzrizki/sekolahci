<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Guru extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Guru_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {
        $this->load->view('guru/guru_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Guru_model->json();
    }

    public function read($id) 
    {
        $row = $this->Guru_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'nik' => $row->nik,
		'nama' => $row->nama,
		'matpel' => $row->matpel,
	    );
            $this->load->view('guru/guru_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('guru'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('guru/create_action'),
	    'id' => set_value('id'),
	    'nik' => set_value('nik'),
	    'nama' => set_value('nama'),
	    'matpel' => set_value('matpel'),
	);
        $this->load->view('guru/guru_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nik' => $this->input->post('nik',TRUE),
		'nama' => $this->input->post('nama',TRUE),
		'matpel' => $this->input->post('matpel',TRUE),
	    );

            $this->Guru_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('guru'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Guru_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('guru/update_action'),
		'id' => set_value('id', $row->id),
		'nik' => set_value('nik', $row->nik),
		'nama' => set_value('nama', $row->nama),
		'matpel' => set_value('matpel', $row->matpel),
	    );
            $this->load->view('guru/guru_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('guru'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'nik' => $this->input->post('nik',TRUE),
		'nama' => $this->input->post('nama',TRUE),
		'matpel' => $this->input->post('matpel',TRUE),
	    );

            $this->Guru_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('guru'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Guru_model->get_by_id($id);

        if ($row) {
            $this->Guru_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('guru'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('guru'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nik', 'nik', 'trim|required');
	$this->form_validation->set_rules('nama', 'nama', 'trim|required');
	$this->form_validation->set_rules('matpel', 'matpel', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "guru.xls";
        $judul = "guru";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
	xlsWriteLabel($tablehead, $kolomhead++, "Nik");
	xlsWriteLabel($tablehead, $kolomhead++, "Nama");
	xlsWriteLabel($tablehead, $kolomhead++, "Matpel");

	foreach ($this->Guru_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteNumber($tablebody, $kolombody++, $data->nik);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama);
	    xlsWriteLabel($tablebody, $kolombody++, $data->matpel);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=guru.doc");

        $data = array(
            'guru_data' => $this->Guru_model->get_all(),
            'start' => 0
        );
        
        $this->load->view('guru/guru_doc',$data);
    }

}

/* End of file Guru.php */
/* Location: ./application/controllers/Guru.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-04-12 03:27:01 */
/* http://harviacode.com */