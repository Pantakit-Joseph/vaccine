<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Parent_model extends CI_Model
{
	public function index($user_id)
	{
		$sql = "SELECT * FROM `users_student` WHERE `user_id` = ? AND `status` = 1";
        $query = $this->db->query($sql, $user_id);
        $re = $query->row();
        $data["users_std"] = $re;

		$sql_parent = "SELECT * FROM `vaccine_parent` WHERE `student_id`=?";
		$qr_parent = $this->db->query($sql_parent, $user_id);
		$parent = $qr_parent->row();

		$data["parent"] = $parent;

		return $data;
	}

	public function submit()
	{
		$title = $this->input->post('title');
		$name_parent = $this->input->post('name_parent');
		$surname_parent = $this->input->post('surname_parent');
		$relation = $this->input->post('relation');
		$parent_vacine = $this->input->post('parent_vacine');
		$number_vacine = $this->input->post('number_vacine');
		$reason = $this->input->post('post_text');
		$data = new stdClass();

		// echo '<pre>';
		// var_dump($this->input->post());
		// echo '</pre>';

		$sql_check = "SELECT * FROM `vaccine_parent` WHERE `student_id`=?";
		$check = $this->db->query($sql_check, array($this->session->user_id));

		if (empty($check->result())) {
			$sql = "INSERT INTO `vaccine_parent`(
				`title_parent`, 
				`name_parent`, 
				`surname_parent`, 
				`student_id`, 
				`relation`, 
				`parent_vacine`, 
				`number_vacine`, 
				`reason_not_vac`, 
				`created_at`, 
				`updated_at`)
				VALUES (?,?,?,?,?,?,?,?,NOW(),NOW())";
			$qr = $this->db->query($sql, array(
				$title,
				$name_parent,
				$surname_parent,
				$this->session->user_id,
				$relation,
				$parent_vacine,
				$number_vacine,
				$reason
			));

			if ($qr) {
				if (!empty($_FILES['parent_vac_img']['name'])) {
					$upload = $this->_uploadimg();
					if ($upload !== null) {
						$sql_up = "UPDATE `vaccine_parent` SET `parent_vac_img`=? WHERE `student_id`=?";
						$this->db->query($sql_up, array($upload, $this->session->user_id));
					} else {
						$data->status = 0;
						$data->message = "ไม่สามารถแนบภาพได้";
						return $data;
					}
				}
			} else {
				$data->status = 0;
				$data->message = "ไม่สามารถบันทึกข้อมูลได้";
				return $data;
			}
		} else {
			$data->status = 0;
			$data->message = "คุณเคยบันทึกแล้ว ไม่สามารถบันทึกข้อมูลซ้ำได้";
			return $data;
		}

		$data->status = 1;
        $data->message = "บันทึกข้อมูลสำเร็จ";
        return $data;
	}

	public function edit() 
	{
		$title = $this->input->post('title');
		$name_parent = $this->input->post('name_parent');
		$surname_parent = $this->input->post('surname_parent');
		$relation = $this->input->post('relation');
		$parent_vacine = $this->input->post('parent_vacine');
		$number_vacine = $this->input->post('number_vacine');
		$reason = $this->input->post('post_text');
		$data = new stdClass();

		// echo '<pre>';
		// var_dump($this->input->post());
		// echo '</pre>';

		$sql = "UPDATE `vaccine_parent` SET 
		`title_parent`=?,
		`name_parent`=?,
		`surname_parent`=?,
		`relation`=?,
		`parent_vacine`=?,
		`number_vacine`=?,
		`reason_not_vac`=?,
		`updated_at`=NOW()
		WHERE `student_id`=?";
		$qr = $this->db->query($sql, array(
			$title,
			$name_parent,
			$surname_parent,
			$relation,
			$parent_vacine,
			$number_vacine,
			$reason,
			$this->session->user_id
		));
		if ($qr) {
			if (!empty($_FILES['parent_vac_img']['name'])) {
				$upload = $this->_uploadimg();
				if ($upload !== null) {
					$sql_up = "UPDATE `vaccine_parent` SET `parent_vac_img`=? WHERE `student_id`=?";
					$this->db->query($sql_up, array($upload, $this->session->user_id));
				} else {
					$data->status = 0;
					$data->message = "ไม่สามารถแนบภาพได้";
					return $data;
				}
			}
		} else {
			$data->status = 0;
			$data->message = "ไม่สามารถแก้ไขข้อมูลได้";
			return $data;
		}

		$data->status = 1;
        $data->message = "แก้ไขข้อมูลสำเร็จ";
        return $data;

	}

	public function parent_vac($group_id)
	{
		$sql = "SELECT `groups`.`group_name`, `users_advisor`.`firstname`, `users_advisor`.`lastname`, `users_advisor`.`signature`,
        `majors`.`major_name`,`users_headdepartment`.`firstname` AS dpm_firstname,`users_headdepartment`.`lastname` AS dpm_lastname,`users_headdepartment`.`signature` AS dpm_signature
        FROM `advisors_groups`
        LEFT JOIN `groups` ON `groups`.`id`=`advisors_groups`.`group_id`
        LEFT JOIN `users_advisor` ON`users_advisor`.`user_id`=`advisors_groups`.`advisor_id` 
        LEFT JOIN `users_headdepartment` ON `users_headdepartment`.`major_id`=`groups`.`major_id`
        LEFT JOIN `majors` ON `majors`.`id`=`groups`.`major_id`
        WHERE `advisors_groups`.`advisor_type`='advisor' AND `advisors_groups`.`group_id`=? AND `advisors_groups`.`status`=1;";
        $query = $this->db->query($sql, $group_id);
		$data = $query->row();

		$sql_list = "SELECT `users_student`.`firstname`, `users_student`.`lastname`, `users_student`.`student_id`,
		`vaccine_parent`.`id` AS pid,
		`vaccine_parent`.`title_parent`,
		`vaccine_parent`.`name_parent`,
		`vaccine_parent`.`surname_parent`,
		`vaccine_parent`.`relation`,
		`vaccine_parent`.`parent_vacine`,
		`vaccine_parent`.`number_vacine`,
		`vaccine_parent`.`parent_vac_img`,
		`vaccine_parent`.`reason_not_vac`
		FROM `users_student` 
		LEFT JOIN `vaccine_parent` ON `users_student`.`user_id` = `vaccine_parent`.`student_id`
		WHERE `users_student`.`group_id`=? AND `users_student`.`status`!=-1
		ORDER BY `users_student`.`student_id` ASC";
		$qr_list = $this->db->query($sql_list, array($group_id));
		$data->students = $qr_list->result();

		// echo '<pre>';
		// var_dump($data);
		// echo '</pre>';

		return $data;
	}

	private function _uploadimg()
	{
		$config['upload_path']          = './storages/parent_vac';
		$config['allowed_types']        = 'jpg|jpeg|png';
		$config['encrypt_name']         = TRUE;
		// $config['max_size']             = 100;
		// $config['max_width']            = 20000;
		// $config['max_height']           = 20000;


		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('parent_vac_img')) {
			return null;
		} else {
			$file = $this->upload->data();
			return $file['file_name'];
		}
	}
}
