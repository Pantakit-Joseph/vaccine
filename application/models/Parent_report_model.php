<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Parent_report_model extends CI_Model
{
	//get all majors items
	private function major_items()
	{
		$sql = "SELECT id, major_name FROM `majors` WHERE `status`=1;";
		$query = $this->db->query($sql);
		return $query->result();
	}
	//get all minors items
	private function minor_items()
	{
		$sql = "SELECT * FROM `minors` WHERE `status`=1;";
		$query = $this->db->query($sql);
		return $query->result();
	}
	//get all groups items
	private function group_items()
	{
		$sql = "SELECT * FROM `groups` WHERE `status`!=-1;";
		$query = $this->db->query($sql);
		return $query->result();
	}
	//get all students items
	private function student_items()
	{
		$sql = "SELECT id, user_id, firstname, lastname, student_id, 
						college_id, major_id, minor_id, group_id, email, status 
					FROM `users_student` WHERE `status`=1;";
		$query = $this->db->query($sql);
		return $query->result();
	}

	//get all parent items
	private function parent_items()
	{
		$sql = "SELECT * FROM `vaccine_parent`";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function get_items()
	{
		//get all all majors items
		$major_items = $this->major_items();

		//get all all minors items
		$minor_items = $this->minor_items();

		//get all all groups items
		$group_items = $this->group_items();

		//get all all students items
		$student_items = $this->student_items();

		//get all all parent items
		$parent_items = $this->parent_items();

		// create unique key arrays for direct access by unique key for performance optimization
		$parent = array();
		foreach ($parent_items as $parent_data) {
			$key = $parent_data->student_id;
			if (!isset($parent[$key])) {
				$parent[$key] = array();
			}
			$item_parent = new stdClass();
			$item_parent->parent_id			= $parent_data->id;
			$item_parent->title_parent		= $parent_data->title_parent;
			$item_parent->name_parent		= $parent_data->name_parent;
			$item_parent->surname_parent	= $parent_data->surname_parent;
			$item_parent->student_id		= $parent_data->student_id;
			$item_parent->relation			= $parent_data->relation;
			$item_parent->parent_vacine		= $parent_data->parent_vacine;
			$item_parent->number_vacine		= $parent_data->number_vacine;
			$item_parent->parent_vac_img	= $parent_data->parent_vac_img;
			$item_parent->reason_not_vac	= $parent_data->reason_not_vac;


			// array_push($parent[$key], $item_parent);
			$parent[$key] = $item_parent;
		}
		// echo '<pre>';
		// var_dump($parent);
		// echo '</pre>';
		// echo '<hr>';


		$items							= new stdClass();
		$item_majors_stats				= new stdClass();
		$item_majors_stats->inject		= 0;
		$item_majors_stats->not_inject	= 0;
		$item_majors_stats->no_data		= 0;

		$items->stats             		= $item_majors_stats;

		$items->items 					= array();

		foreach ($major_items as $major) {
			$item_major					= new stdClass();
			$item_major->major_id		= $major->id;
			$item_major->major_name		= $major->major_name;

			$item_major_stats				= new stdClass();
			$item_major_stats->inject		= 0;
			$item_major_stats->not_inject	= 0;
			$item_major_stats->no_data		= 0;
			$item_major->stats             	= $item_major_stats;

			// $item_major->minors           			= new stdClass();
			$item_minors_stats 						= new stdClass();
			$item_minors_stats->inject				= 0;
			$item_minors_stats->not_inject			= 0;
			$item_minors_stats->no_data				= 0;
			$item_major->stats		= $item_minors_stats;
			$item_major->items		= array();

			foreach ($minor_items as $minor) {
				if ($minor->major_id == $major->id) {
					$item_minor                 			= new stdClass();
					$item_minor->major_id       			= $minor->major_id;
					$item_minor->major_name       			= $major->major_name;
					$item_minor->minor_id       			= $minor->id;
					$item_minor->minor_name     			= $minor->minor_name;

					$item_minor_stats             			= new stdClass();
					$item_minor_stats->inject				= 0;
					$item_minor_stats->not_inject			= 0;
					$item_minor_stats->no_data				= 0;
					$item_minor->stats            			= $item_minor_stats;

					// $item_minor->groups         			= new stdClass();
					$item_groups_stats 						= new stdClass();
					$item_groups_stats->inject				= 0;
					$item_groups_stats->not_inject			= 0;
					$item_groups_stats->no_data				= 0;
					$item_minor->stats						= $item_groups_stats;
					$item_minor->items						= array();

					foreach ($group_items as $group) {
						// if ($group->major_id == $major->id && $group->minor_id == $minor->id) {
						if ($group->minor_id == $minor->id) {
							$item_group                     = new stdClass();
							$item_group->major_id           = $group->major_id;
							$item_group->major_name         = $major->major_name;
							$item_group->minor_id           = $group->minor_id;
							$item_group->minor_name         = $minor->minor_name;
							$item_group->group_id           = $group->id;
							$item_group->group_name         = $group->group_name;

							$item_group_stats             	= new stdClass();
							$item_group_stats->inject		= 0;
							$item_group_stats->not_inject	= 0;
							$item_group_stats->no_data		= 0;
							$item_group->stats            	= $item_group_stats;

							$item_group->students         	= array();
							foreach ($student_items as $student) {
								// if ($student->major_id == $major->id && $student->minor_id == $minor->id && $student->group_id == $group->id) {
								if ($student->group_id == $group->id) {
									$item_student                		= new stdClass();
									$item_student->id           		= $student->id;
									$item_student->user_id       		= $student->user_id;
									$item_student->student_id   		= $student->student_id;
									$item_student->firstname   			= $student->firstname;
									$item_student->lastname   			= $student->lastname;
									$item_student->email   				= $student->email;

									$item_student->parent_status		= 0;
									$item_student->parent_status_remark	= null;
									$item_student->parent_items	= new stdClass();

									if (isset($parent[$item_student->user_id])) {
										$item_student->parent_items	= $parent[$item_student->user_id];
										// echo '<pre>';
										// var_dump($parent[$item_student->user_id]);
										// echo '</pre>';
										// echo '<hr>';

										$tmps_parent = $parent[$item_student->user_id];
										if ($tmps_parent->parent_vacine === '1') {
											$item_student->parent_status = 1;

											$item_group_stats->inject++;
											$item_minor_stats->inject++;
											$item_major_stats->inject++;
										} elseif ($tmps_parent->parent_vacine === '0') {
											$item_student->parent_status = 0;

											$item_group_stats->not_inject++;
											$item_minor_stats->not_inject++;
											$item_major_stats->not_inject++;
										}
									} else {
										$item_student->parent_status = -1;

										$item_group_stats->no_data++;
										$item_minor_stats->no_data++;
										$item_major_stats->no_data++;
									}

									array_push($item_group->students, $item_student);
								}
							}
							array_push($item_minor->items, $item_group);
							//calculate stats of all groups
							$item_minor->stats->inject			+= $item_group->stats->inject;
							$item_minor->stats->not_inject		+= $item_group->stats->not_inject;
							$item_minor->stats->no_data			+= $item_group->stats->no_data;
						}
					}
					array_push($item_major->items, $item_minor);
					//calculate stats of all minors 

					$item_major->stats->inject			+= $item_minor->stats->inject;
					$item_major->stats->not_inject		+= $item_minor->stats->not_inject;
					$item_major->stats->no_data			+= $item_minor->stats->no_data;
				}
			}
			array_push($items->items, $item_major);
			//calculate stats of all majors

			$items->stats->inject			+= $item_major->stats->inject;
			$items->stats->not_inject		+= $item_major->stats->not_inject;
			$items->stats->no_data			+= $item_major->stats->no_data;
		}

		return $items;
	}

	public function menu()
	{
		$data['major_id'] = $this->input->get('major_id');
		$data['majors'] = $this->major_items();
		return $data;
	}

	public function majors()
	{
		return $this->get_items();
	}

	public function major($major_id)
	{
		$items = $this->get_items();
		$data = null;
		foreach ($items->items as $major) {
			if ($major->major_id == $major_id) {
				// echo "<pre>";
				// print_r($major);
				// exit();
				return $major;
			}
		}
		return $data;
	}

	public function minor($minor_id)
	{
		$items = $this->get_items();
		$data = null;
		foreach ($items->items as $major) {
			foreach ($major->items as $minor) {
				if ($minor->minor_id == $minor_id) {
					// echo "<pre>";
					// print_r($minor);
					// exit();
					return $minor;
				}
			}
		}
		return $data;
	}

	public function group($group_id)
	{
		$items = $this->get_items();
		$data = null;
		foreach ($items->items as $major) {
			foreach ($major->items as $minor) {
				foreach ($minor->items as $group) {
					if ($group->group_id == $group_id) {
						// echo "<pre>";
						// print_r($group);
						// exit();
						return $group;
					}
				}
			}
		}
		return $data;
	}
}
