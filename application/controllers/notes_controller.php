<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class notes_controller extends CI_Controller {

	public function index()
	{
		$notes = $this->note_model->getNotes();
		$this->load->view('notes_view', array('notes' => $notes));
	}

	public function create()
	{
		$result = $this->note_model->add($this->input->post());
		
		if($result)
		{
			echo json_encode(array(
				"status" => "success",
				"request" => "create",
				"row" => $result));
			//redirect('/');
		}
		else
		{
			echo "Something's amiss";
		}
	}

	public function delete()
	{
		$delete = $this->note_model->delete($this->input->post());
		if($delete)
		{
			echo json_encode("Delete success");
			//redirect('/');
		}
		else
		{
			echo ("Something's amiss");
		}
	}

	public function update()
	{
		$update = $this->note_model->update($this->input->post());
		if($update)
		{
			echo json_encode("success");
			//redirect('/');
		}
		else
		{
			echo ("Something's amiss");
		}
	}

	public function updateTitle()
	{
		$update = $this->note_model->updateTitle($this->input->post());
		if($update)
		{
			echo json_encode("success");
			//redirect('/');
		}
		else
		{
			echo ("Something's amiss");
		}
	}
}