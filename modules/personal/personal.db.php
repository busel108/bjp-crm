<?php
include_once "../../system/common/inc.db_connect.php";

class personal extends db_connect{
	private $id;
	
	public function __construct($dbo=NULL){
		parent::__construct($dbo);
	}
	
	/**********Справочная информация***********/
	
	public function show_gender_list(){
		$query = "SELECT `id`, `gender_name` FROM `hdbk_user_gender` ORDER BY `gender_name`";
        $sth = $this->db->prepare($query);
		$sth->execute();
		
        return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function show_function_list(){
		$query = "SELECT `id`, `function_name` FROM `hdbk_user_function` ORDER BY `function_name`";
        $sth = $this->db->prepare($query);
		$sth->execute();
		
        return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function show_education_list(){
		$query = "SELECT `id`, `education_name` FROM `hdbk_user_education` ORDER BY `education_name`";
        $sth = $this->db->prepare($query);
		$sth->execute();
		
        return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function show_subdivision_list(){
		$query = "SELECT `id`, `subdivision_name` FROM `hdbk_user_subdivision` ORDER BY `subdivision_name`";
        $sth = $this->db->prepare($query);
		$sth->execute();
		
        return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function show_category_list(){
		$query = "SELECT `id`, `category_name` FROM `hdbk_user_category` ORDER BY `category_name`";
        $sth = $this->db->prepare($query);
		$sth->execute();
		
        return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	/*****************************************/
	
	//Получение данных для просмотра сотрудников
	public function show_user_full(){
		$query = "SELECT t1.`id`, t1.`user_f`, t1.`user_i`, t1.`user_o`, t1.`user_gender`, t1.`user_dob`, t1.`user_receipt`,  t1.`user_function`, t1.`user_education`, t1.`user_subdivision`, t1.`user_category`, t2.`gender_name`, t3.`function_name`, t4.`education_name`, t5.`subdivision_name`, t6.`category_name` FROM `users_data` AS t1
			LEFT JOIN `hdbk_user_gender` AS t2 ON t1.`user_gender` = t2.`id`
			LEFT JOIN `hdbk_user_function` AS t3 ON t1.`user_function` = t3.`id`
			LEFT JOIN `hdbk_user_education` AS t4 ON t1.`user_education` = t4.`id`
			LEFT JOIN `hdbk_user_subdivision` AS t5 ON t1.`user_subdivision` = t5.`id`
			LEFT JOIN `hdbk_user_category` AS t6 ON t1.`user_category` = t6.`id`
			ORDER BY t1.`user_subdivision`";
        $sth = $this->db->prepare($query);
        $sth->execute();
		
		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	//Получение данных для просмотра данных о контрактах
	public function show_contracts_full(){
		$query = "SELECT t1.`id`, t1.`user_f`, t1.`user_i`, t1.`user_o`, t1.`user_subdivision`, t1.`contract_num`, t1.`contract_date_begin`, t1.`contract_date_end`, t1.`contract_extend_begin`,
					t1.`contract_extend_end`, t1.`user_function`, t2.`subdivision_name`, t3.`function_name` FROM `users_data` AS t1
			LEFT JOIN `hdbk_user_subdivision` AS t2 ON t1.`user_subdivision` = t2.`id`
			LEFT JOIN `hdbk_user_function` AS t3 ON t1.`user_function` = t3.`id`
			ORDER BY t1.`user_subdivision`";
        $sth = $this->db->prepare($query);
        $sth->execute();
		
		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	//Получение данных сотрудника для редактирования
	public function edit_user($data){
		$query = "SELECT `id`, `user_f`, `user_i`, `user_o`, `user_dob`, `user_receipt`, `user_gender`, `user_function`, `user_education`, `user_subdivision`, `user_category` FROM `users_data` WHERE `id` = :user_id";
        $sth = $this->db->prepare($query);
		$sth->execute($data);
		 
        return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	//Получение данных сотрудника по контрактам для редактирования
	public function edit_contract($data){
		$query = "SELECT `id`, `user_f`, `user_i`, `user_o`, `contract_num`, `contract_date_begin`, `contract_date_end`, `contract_extend_begin`, `contract_extend_end` FROM `users_data` WHERE `id` = :user_id";
        $sth = $this->db->prepare($query);
		$sth->execute($data);
		 
        return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	//Добавление нового сотрудника
	public function create_user($data){
		$query = "INSERT INTO `users_data` (`fio`, `user_f`, `user_i`, `user_o`, `user_dob`, `user_receipt`, `user_gender`, `user_function`, `user_education`, `user_subdivision`, `user_category`)
            VALUES (CONCAT(:user_f, ' ', :user_i, ' ', :user_o), :user_f, :user_i, :user_o, :user_dob, :user_receipt, :user_gender, :user_function, :user_education, :user_subdivision, :user_category)";
        $sth = $this->db->prepare($query);
        $sth->execute($data);
		
		return $this->db->lastInsertId();	
	}
	
	//Удаление сотрудника
	public function delete_user($data){
		$query = "DELETE FROM users_data WHERE id = :user_id";
        $sth = $this->db->prepare($query);
		
        return $sth->execute($data);
	}

	//Обновление данных сотрудника
	public function update_user($data){
		$query = "UPDATE `users_data` SET `user_f`= :user_f, `user_i`= :user_i, `user_o` = :user_o, `user_dob` = :user_dob, `user_receipt` = :user_receipt, `user_gender`= :user_gender,
			`user_function` = :user_function,`user_education` = :user_education,`user_subdivision` = :user_subdivision, `user_category` = :user_category WHERE `id` = :user_id";
        $sth = $this->db->prepare($query);
		
        return $sth->execute($data);
	}
	
	//Обновление данных сотрудника по контракту
	public function update_contract($data){
		$query = "UPDATE `users_data` SET `user_f`= :user_f, `user_i`= :user_i, `user_o` = :user_o, `contract_num` = :contract_num, `contract_date_begin` = :contract_date_begin,
		`contract_date_end`= :contract_date_end, `contract_extend_begin` = :contract_extend_begin,`contract_extend_end` = :contract_extend_end WHERE `id` = :user_id";
        $sth = $this->db->prepare($query);
		
        return $sth->execute($data);
	}
}
?>