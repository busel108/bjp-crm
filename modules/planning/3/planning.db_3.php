<?php
include_once "../../../system/common/inc.db_connect.php";

class planning extends db_connect{
	private $id;
	
	public function __construct($dbo=NULL){
		parent::__construct($dbo);
	}
	
	/**********Справочная информация***********/
	

	/******Новые запросы - 2 уровень ******/
	public function select_leader_list(){
		$query = "SELECT t1.`id`, t1.`fio` AS value FROM `users_data` as t1 LEFT JOIN `obj_info` as t2 ON t1.`id` = t2.`v4_1_lv1` OR t1.`id` = t2.`v4_2_lv1` WHERE t1.`id` = t2.`v4_1_lv1` OR t1.`id` = t2.`v4_2_lv1` GROUP BY t1.`id`";
    
		$sth = $this->db->prepare($query);
		$sth->execute();
		
        return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	
	public function select_obj_list($data){
		$query = "SELECT t1.`id`, t1.`v1_lv1`, t1.`v2_lv1`, t2.`fio` as `v4_1_lv1`, t3.`fio` as `v4_2_lv1` FROM `obj_info` AS t1 
		LEFT JOIN `users_data` AS t2 ON t1.`v4_1_lv1` = t2.`id` 
		LEFT JOIN `users_data` AS t3 ON t1.`v4_2_lv1` = t3.`id`
		WHERE t1.`v4_1_lv1` = :leader_id OR t1.`v4_2_lv1` = :leader_id";
		$sth = $this->db->prepare($query);
		$sth->execute($data);
		
		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function select_obj_types_of_jobs($data){
		$query = "SELECT t1.`id`, t1.`obj_id`, t1.`jobs_id`, t1.`name_input`, t1.`value_input`, t2.`subdivision_name`, t3.`type_name` AS name_jobs , t3.`type_name_abbreviation` AS name_jobs_abbv FROM `obj_types_of_jobs` AS t1 
		LEFT JOIN `hdbk_user_subdivision` AS t2 ON t1.subdivision_id = t2.id
		LEFT JOIN `hdbk_types_of_jobs` AS t3 ON t1.jobs_id = t3.id
		WHERE t1.`obj_id` = :obj_id";
		
		$sth = $this->db->prepare($query);
		$sth->execute($data);
		
		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function select_types_of_jobs_list(){
		$query = "SELECT `id`, `type_name` AS value, `type_name_abbreviation` FROM `hdbk_types_of_jobs`";
		
		$sth = $this->db->prepare($query);
		$sth->execute();
		
		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function select_types_of_jobs_abbr($data){
		$query = "SELECT `id`, `type_name_abbreviation` FROM `hdbk_types_of_jobs` WHERE `id` = :jobs_id";
		
		$sth = $this->db->prepare($query);
		$sth->execute($data);
		
		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function select_subdivision_list(){
		$query = "SELECT `id`, `subdivision_name` AS value FROM `hdbk_user_subdivision`  WHERE `part_in_design` = 1";
		
		$sth = $this->db->prepare($query);
		$sth->execute();
		
		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function create_types_of_jobs_obj($data){
		$query = "INSERT INTO `obj_types_of_jobs`(`obj_id`, `jobs_id`, `subdivision_id`, `name_input`) VALUES (:obj_id, :jobs_id, :subdivision_id, :name_input)";
    
		$sth = $this->db->prepare($query);
		$sth->execute($data);
		
        return $this->db->lastInsertId();
	}
	
	public function select_edit_types_of_jobs($data){
		$query = "SELECT `id`, `obj_id`, `subdivision_id`, `jobs_id`, `name_input`, `value_input` FROM `obj_types_of_jobs` WHERE `obj_id` = :obj_id AND `jobs_id` = :jobs_id";
		
		$sth = $this->db->prepare($query);
		$sth->execute($data);
		
		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function update_types_of_jobs($data){
		$query = "UPDATE `obj_types_of_jobs` SET `value_input` = :value_input WHERE `id` = :input_id";
		$sth = $this->db->prepare($query);
		
		return $sth->execute($data);
	}
	
	public function delete_types_of_jobs($data){
		$query = "DELETE FROM `obj_types_of_jobs` WHERE `obj_id` = :obj_id AND `jobs_id` = :jobs_id";
		$sth = $this->db->prepare($query);
		
		return $sth->execute($data);
	}
	
	public function edit_global_obj($query){
		$sth = $this->db->prepare($query);
		$sth->execute();
		
		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function update_obj_lv2($data){
		$query = "UPDATE `obj_info` SET `v27_lv2` = :v27_lv2, `v28_lv2` = :v28_lv2, `v29_lv2` = :v29_lv2, `v30_lv2` = :v30_lv2, 
		`v31_lv2` = :v31_lv2, `v32_lv2` = :v32_lv2, `v33_lv2` = :v33_lv2, `v34_lv2` = :v34_lv2, `v35_lv2` = :v35_lv2, `v36_lv2` = :v36_lv2, `v37_lv2` = :v37_lv2,
		`v38_lv2` = :v38_lv2, `v39_lv2` = :v39_lv2, `v40_lv2` = :v40_lv2, `v41_lv2` = :v41_lv2, `v42_lv2` = :v42_lv2, `v43_lv2` = :v43_lv2, `v44_lv2` = :v44_lv2, 
		`v45_lv2` = :v45_lv2, `v46_lv2` = :v46_lv2, `v47_lv2` = :v47_lv2, `v48_lv2` = :v48_lv2, `v49_lv2` = :v49_lv2, `v50_lv2` = :v50_lv2, `v51_lv2` = :v51_lv2, 
		`v52_lv2` = :v52_lv2, `v53_lv2` = :v53_lv2, `v54_lv2` = :v54_lv2, `v55_lv2` = :v55_lv2, `v56_lv2` = :v56_lv2, `v57_lv2` = :v57_lv2, `v58_lv2` = :v58_lv2, 
		`v59_lv2` = :v59_lv2, `v60_lv2` = :v60_lv2, `v61_lv2` = :v61_lv2, `v62_lv2` = :v62_lv2 WHERE `id` = :obj_id";
		$sth = $this->db->prepare($query);
		
		return $sth->execute($data);
	}
	
	/*****************************************/
}
?>