<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class note_model extends CI_Model {

	public function add($note)
	{
		$query = "INSERT INTO notes (title, created_at, updated_at) VALUES (?, NOW(), NOW())";
		$this->db->query($query, $note['noteTitle']);
		$id = $this->db->insert_id();
		return $this->get_note($id);
	}

	public function getNotes()
	{
		$query = "SELECT * FROM notes";
		$result = $this->db->query($query)->result_array();
		return ($result);
	}

	public function delete($deleteNote)
	{
		$query = "DELETE FROM notes WHERE id = ?";
		$result = $this->db->query($query, array($deleteNote['noteID']));
		return ($result);
	}

	public function update($updateNote)
	{
		$query = "UPDATE notes SET description = ? WHERE id = ?";
		$result = $this->db->query($query, array($updateNote['noteAppend'], $updateNote['noteID']));
		return $result;
	}

	public function updateTitle($updateNote)
	{
		$query = "UPDATE notes SET title = ? WHERE id = ?";
		$result = $this->db->query($query, array($updateNote['titleAppend'], $updateNote['noteID']));
		return $result;
	}

	public function get_note($id)
	{
		return $this->db->where('id', $id)->get('notes')->row_array();
	}
}