<?php
include_once "../../system/common/inc.db_connect.php";

class orders extends db_connect{
	private $id;
	
	public function __construct($dbo=NULL){
		parent::__construct($dbo);
	}
	
	/**********Справочная информация***********/
	
	public function show_corr_list(){
		$query = "	SELECT `id`, `org_name` FROM `hdbk_customers`
					ORDER BY `org_name`
					";
        $sth = $this->db->prepare($query);
		$sth->execute();
		
        return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function show_executor_list(){
		$query = "	SELECT `id`, `fio` FROM `users_data`
					ORDER BY `fio`";
        $sth = $this->db->prepare($query);
		$sth->execute();
		
        return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function show_position_list(){
		$query = "	SELECT `id`, `function_name` FROM `hdbk_user_function`
					ORDER BY `id`";
        $sth = $this->db->prepare($query);
		$sth->execute();
		
        return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function show_doc_type_list() {
		$query = "	SELECT * FROM `hdbk_doc_types`
					ORDER BY `id`";
					
		$sth = $this->db->prepare($query);
		$sth->execute();
		
		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	/*****************************************/
	
	//Получение данных для просмотра сотрудников
	public function show_order_full(){
		$query = "SELECT t1.`id`, t1.`id_doc_type`, t4.`doc_type`, t1.`income_number`, t1.`topic`, t1.`income_date`, t1.`reg_num`, t2.`org_name`, t3.`fio`,  t1.`exec_date`, t1.`exec_mark`, t1.`doc_order`, t1.`doc_exec_order` FROM `orders` AS t1
			LEFT JOIN `hdbk_customers` AS t2 ON t1.`corr` = t2.`id`
			LEFT JOIN `users_data` AS t3 ON t1.`executor` = t3.`id`
			INNER JOIN `hdbk_doc_types` AS t4 ON t1.`id_doc_type` = t4.`id`
			ORDER BY t1.`id`";
        $sth = $this->db->prepare($query);
        $sth->execute();
		
		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	//Получение данных для просмотра поручений
	public function show_exec_full($data){
		$query = "SELECT t1.`id`, t2.`function_name`, t3.`fio`, t1.`exec_date`, t1.`exec_mark`, t4.`reg_num`, t4.`income_date`, t1.`executor`, t4.`id_doc_type` FROM `executors` AS t1
				INNER JOIN `users_data` AS t3 ON t1.`executor` = t3.`id`
				INNER JOIN `hdbk_user_function` AS t2 ON t3.`user_function` = t2.`id`
				INNER JOIN `orders` AS t4 ON t4.`id` = t1.`por_id`
				WHERE t1.`por_id` = :exec_id";
        $sth = $this->db->prepare($query);
        $sth->execute($data);
		
		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	//Получение данных поручения для редактирования
	public function edit_order($data){
		$query = "SELECT `id`, `id_doc_type`, `topic`, `income_date`, `reg_num`, `exec_date`, `corr`, `executor`, `exec_mark` FROM `orders` WHERE `id` = :order_id";
        $sth = $this->db->prepare($query);
		$sth->execute($data);
		 
        return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	//Добавление нового поручения
	public function create_order($data){
		$query = "INSERT INTO `orders` (`id_doc_type`, `topic`, `income_date`, `reg_num`, `corr`)
            VALUES (:doc_type, :topic, :income_date, :reg_num, :corr)";
        $sth = $this->db->prepare($query);
        $sth->execute($data);
		
		return $this->db->lastInsertId();	
	}
	
	//Добавление исполнителя по поручению
	public function create_exec($data){
		$query = "INSERT INTO `executors` (`position`, `executor`, `exec_date`, `exec_mark`, `por_id`)
					VALUES (:position, :executor, :exec_date, :exec_mark, :order_id)";
        $sth = $this->db->prepare($query);
        $sth->execute($data);
		
		return $this->db->lastInsertId();	
	}
	
	//Удаление поручения
	public function delete_order($data){
		$query = "DELETE FROM `orders` WHERE id = :order_id";
        $sth = $this->db->prepare($query);
		
        return $sth->execute($data);
	}

	//Обновление данных о поручении
	public function update_order($data){
		$query = "UPDATE `orders` SET `id_doc_type` = :doc_type, `topic` = :topic, `income_date` = :income_date, `reg_num` = :reg_num, `corr` = :corr
				WHERE `id` = :order_id";
        $sth = $this->db->prepare($query);
		
        return $sth->execute($data);
	}
	
	public function get_executor($data) {
		$query = "SELECT `fio` FROM `users_data` WHERE `id` = :executor";
		
		$sth = $this->db->prepare($query);
		$sth->execute($data);
		
		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function add_executor($data) {
		$query = "INSERT INTO `executors` (`executor`, `exec_date`, `exec_mark`, `por_id`)
					VALUES (:executor, :exec_date, :exec_mark, :id)";
		
		$sth = $this->db->prepare($query);
		$sth->execute($data);
		
		return $this->db->lastInsertId();
	}
	
	public function show_order($data) {
		$query = "SELECT t1.`id`, t1.`id_doc_type`, t3.`doc_type`, t1.`topic`, t1.`income_date`, t1.`reg_num`, t2.`org_name`
					FROM `orders` AS t1
					INNER JOIN `hdbk_customers` AS t2 ON t2.`id` = t1.`corr`
					INNER JOIN `hdbk_doc_types` AS t3 ON t3.`id` = t1.`id_doc_type`
					WHERE t1.`id` = :order_id";
					
		$sth = $this->db->prepare($query);
		$sth->execute($data);
		 
        return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function select_all_exec($data) {
		$query = "	SELECT t2.`fio`, t1.`exec_date`, t1.`exec_mark`, t1.`executor`, t1.`id`
					FROM `executors` AS t1
					INNER JOIN `users_data` AS t2 ON t2.`id` = t1.`executor`
					WHERE t1.`por_id` = :exec_id";
	
		$sth = $this->db->prepare($query);
		$sth->execute($data);
		 
        return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function update_executor($data) {
		$query = "	UPDATE `executors` SET `executor`= :executor, `exec_date` = :exec_date, `exec_mark` = :exec_mark
					WHERE `id` = :id";
        $sth = $this->db->prepare($query);
		
        return $sth->execute($data);
	}
	
	public function delete_exec($data) {
		$query = "DELETE FROM `executors` WHERE id = :exec_id";
        $sth = $this->db->prepare($query);
		
        return $sth->execute($data);
	}
	
	public function show_alert_msg() {
		$query = "	SELECT t1.`id`, t1.`exec_date`, t2.`fio`
					FROM `executors` AS t1
					INNER JOIN `users_data` AS t2 ON t1.`executor` = t2.`id`";
	
		$sth = $this->db->prepare($query);
		$sth->execute();
		 
        return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
}
?>