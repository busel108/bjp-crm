<?php
include_once "../../system/common/inc.db_connect.php";

class hdbk extends db_connect{
	private $id;
	
	public function __construct($dbo=NULL){
		parent::__construct($dbo);
	}
	
	/**********Справочная информация***********/
	
	public function select_types_of_jobs_full(){
		$query = "SELECT `id`, `type_name` FROM `hdbk_types_of_jobs`";
        $sth = $this->db->prepare($query);
		$sth->execute();
		
        return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function select_edit_types_of_jobs_full($data){
		$query = "SELECT * FROM `hdbk_types_of_jobs` WHERE `id` = :id";
        $sth = $this->db->prepare($query);
		$sth->execute($data);
		
        return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function select_delete_types_of_jobs_full($data){
		$query = "SELECT * FROM `hdbk_types_of_jobs` WHERE `id` = :id";
        $sth = $this->db->prepare($query);
		$sth->execute($data);
		
        return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function update_types_of_jobs_full($data){
		$query = "UPDATE `hdbk_types_of_jobs` SET `type_name` = :type_name,`type_name_abbreviation` = :type_name_abbreviation WHERE `id` = :id";
        $sth = $this->db->prepare($query);

        return $sth->execute($data);
	}
	
	public function delete_types_of_jobs_full($data){
		$query = "DELETE FROM `hdbk_types_of_jobs` WHERE `id` = :id";
        $sth = $this->db->prepare($query);

        return $sth->execute($data);
	}
	
	public function add_types_of_jobs_full($data){
		$query = "INSERT INTO `hdbk_types_of_jobs` (`type_name`, `type_name_abbreviation`)
					VALUES (:type_name, :type_name_abbreviation)";
        $sth = $this->db->prepare($query);

        return $sth->execute($data);
	}

	/*****************************************/
	
	public function select_education_full(){
		$query = "SELECT `id`, `education_name` FROM `hdbk_user_education`";
        $sth = $this->db->prepare($query);
		$sth->execute();
		
        return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function select_edit_education_full($data){
		$query = "SELECT * FROM `hdbk_user_education` WHERE `id` = :id";
        $sth = $this->db->prepare($query);
		$sth->execute($data);
		
        return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function update_education_full($data){
		$query = "UPDATE `hdbk_user_education` SET `education_name` = :education_name WHERE `id` = :id";
        $sth = $this->db->prepare($query);

        return $sth->execute($data);
	}
	
	public function delete_education_full($data){
		$query = "DELETE FROM `hdbk_user_education` WHERE `id` = :id";
        $sth = $this->db->prepare($query);

        return $sth->execute($data);
	}
	
	public function add_education_full($data){
		$query = "INSERT INTO `hdbk_user_education` (`education_name`)
					VALUES (:education_name)";
        $sth = $this->db->prepare($query);

        return $sth->execute($data);
	}
	
	public function select_delete_education_full($data){
		$query = "SELECT * FROM `hdbk_user_education` WHERE `id` = :id";
        $sth = $this->db->prepare($query);
		$sth->execute($data);
		
        return $sth->fetchAll(PDO::FETCH_ASSOC);
	}

	/*****************************************/
	
	public function select_function_full(){
		$query = "SELECT `id`, `function_name` FROM `hdbk_user_function`";
        $sth = $this->db->prepare($query);
		$sth->execute();
		
        return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function select_edit_function_full($data){
		$query = "SELECT * FROM `hdbk_user_function` WHERE `id` = :id";
        $sth = $this->db->prepare($query);
		$sth->execute($data);
		
        return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function update_function_full($data){
		$query = "UPDATE `hdbk_user_function` SET `function_name` = :function_name WHERE `id` = :id";
        $sth = $this->db->prepare($query);

        return $sth->execute($data);;
	}
	
	public function delete_function_full($data){
		$query = "DELETE FROM `hdbk_user_function` WHERE `id` = :id";
        $sth = $this->db->prepare($query);

        return $sth->execute($data);
	}
	
	public function select_delete_function_full($data){
		$query = "SELECT * FROM `hdbk_user_function` WHERE `id` = :id";
        $sth = $this->db->prepare($query);
		$sth->execute($data);
		
        return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function add_function_full($data){
		$query = "INSERT INTO `hdbk_user_function` (`function_name`)
					VALUES (:function_name)";
        $sth = $this->db->prepare($query);

        return $sth->execute($data);
	}

	/*****************************************/
	
	public function select_subdivision_full(){
		$query = "SELECT `id`, `subdivision_name`, `part_in_design` FROM `hdbk_user_subdivision`";
        $sth = $this->db->prepare($query);
		$sth->execute();
		
        return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function select_edit_subdivision_full($data){
		$query = "SELECT * FROM `hdbk_user_subdivision` WHERE `id` = :id";
        $sth = $this->db->prepare($query);
		$sth->execute($data);
		
        return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function update_subdivision_full($data){
		$query = "UPDATE `hdbk_user_subdivision` SET `subdivision_name` = :subdivision_name, `part_in_design` = :checked WHERE `id` = :id";
        $sth = $this->db->prepare($query);

        return $sth->execute($data);;
	}
	
	public function delete_subdivision_full($data){
		$query = "DELETE FROM `hdbk_user_subdivision` WHERE `id` = :id";
        $sth = $this->db->prepare($query);

        return $sth->execute($data);
	}
	
	public function select_delete_subdivision_full($data){
		$query = "SELECT * FROM `hdbk_user_subdivision` WHERE `id` = :id";
        $sth = $this->db->prepare($query);
		$sth->execute($data);
		
        return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function add_subdivision_full($data){
		$query = "INSERT INTO `hdbk_user_subdivision` (`subdivision_name`, `part_in_design`) VALUES (:subdivision_name, :checked)";
        $sth = $this->db->prepare($query);

        return $sth->execute($data);
	}

	/*****************************************/
	
	public function select_source_of_finance_full(){
		$query = "SELECT `id`, `value` FROM `hdbk_source_of_finance`";
        $sth = $this->db->prepare($query);
		$sth->execute();
		
        return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function select_edit_source_of_finance_full($data){
		$query = "SELECT * FROM `hdbk_source_of_finance` WHERE `id` = :id";
        $sth = $this->db->prepare($query);
		$sth->execute($data);
		
        return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function update_source_of_finance_full($data){
		$query = "UPDATE `hdbk_source_of_finance` SET `value` = :value WHERE `id` = :id";
        $sth = $this->db->prepare($query);

        return $sth->execute($data);;
	}
	
	public function delete_source_of_finance_full($data){
		$query = "DELETE FROM `hdbk_source_of_finance` WHERE `id` = :id";
        $sth = $this->db->prepare($query);

        return $sth->execute($data);
	}
	
	public function select_delete_source_of_finance_full($data){
		$query = "SELECT * FROM `hdbk_source_of_finance` WHERE `id` = :id";
        $sth = $this->db->prepare($query);
		$sth->execute($data);
		
        return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function add_source_of_finance_full($data){
		$query = "INSERT INTO `hdbk_source_of_finance` (`value`) VALUES (:value)";
        $sth = $this->db->prepare($query);

        return $sth->execute($data);
	}

	/*****************************************/
	
	public function select_doc_reason_for_development_psd_full(){
		$query = "SELECT `id`, `value` FROM `hdbk_doc_reason_for_development_psd`";
        $sth = $this->db->prepare($query);
		$sth->execute();
		
        return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function select_edit_doc_reason_for_development_psd_full($data){
		$query = "SELECT * FROM `hdbk_doc_reason_for_development_psd` WHERE `id` = :id";
        $sth = $this->db->prepare($query);
		$sth->execute($data);
		
        return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function update_doc_reason_for_development_psd_full($data){
		$query = "UPDATE `hdbk_doc_reason_for_development_psd` SET `value` = :value WHERE `id` = :id";
        $sth = $this->db->prepare($query);

        return $sth->execute($data);;
	}
	
	public function delete_doc_reason_for_development_psd_full($data){
		$query = "DELETE FROM `hdbk_doc_reason_for_development_psd` WHERE `id` = :id";
        $sth = $this->db->prepare($query);

        return $sth->execute($data);
	}
	
	public function select_delete_doc_reason_for_development_psd_full($data){
		$query = "SELECT * FROM `hdbk_doc_reason_for_development_psd` WHERE `id` = :id";
        $sth = $this->db->prepare($query);
		$sth->execute($data);
		
        return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function add_doc_reason_for_development_psd_full($data){
		$query = "INSERT INTO `hdbk_doc_reason_for_development_psd` (`value`) VALUES (:value)";
        $sth = $this->db->prepare($query);

        return $sth->execute($data);
	}

	/*****************************************/
	
	public function select_customers_full(){
		$query = "SELECT `id`, `org_name`, `legal_address`, `mailing_address`, `unp`, `okpo`, `bank_details`, `head_fio` FROM `hdbk_customers`";
        $sth = $this->db->prepare($query);
		$sth->execute();
		
        return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function select_edit_customers_full($data){
		$query = "SELECT * FROM `hdbk_customers` WHERE `id` = :id";
        $sth = $this->db->prepare($query);
		$sth->execute($data);
		
        return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function update_customers_full($data){
		$query = "UPDATE `hdbk_customers` SET `org_name` = :org_name,  `legal_address` = :legal_address, `mailing_address` = :mailing_address, `unp`=:unp, `okpo`=:okpo,
				`bank_details`=:bank_details, `head_fio`=:head_fio 
				WHERE `id` = :id";
        $sth = $this->db->prepare($query);

        return $sth->execute($data);;
	}
	
	public function delete_customers_full($data){
		$query = "DELETE FROM `hdbk_customers` WHERE `id` = :id";
        $sth = $this->db->prepare($query);

        return $sth->execute($data);
	}
	
	public function select_delete_customers_full($data){
		$query = "SELECT * FROM `hdbk_customers` WHERE `id` = :id";
        $sth = $this->db->prepare($query);
		$sth->execute($data);
		
        return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function add_customers_full($data){
		$query = "INSERT INTO `hdbk_customers` (`org_name`, `legal_address`, `mailing_address`, `unp`, `okpo`, `bank_details`, `head_fio`) 
				VALUES (:org_name, :legal_address, :mailing_address, :unp, :okpo, :bank_details, :head_fio)";
        $sth = $this->db->prepare($query);

        return $sth->execute($data);
	}

	/*****************************************/
}
?>