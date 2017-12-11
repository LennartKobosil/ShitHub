<?php
namespace ShitHub\SQL;

class ShitHubSQL{

	private $pdo = null; //pdo object

	public function __construct(){
		try{
			$this->pdo = new \PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_UNAME,DB_PW);
		}catch(\PDOException $e){
			\ShitHub\Core\Loader::getLogger()->alert('PDOException: '.$e->getMessage());
		}
	}
	public function save_snippet($title, $description, $language, $tags){
		if($this->pdo != null){
			$query = $this->pdo->prepare("INSERT INTO snippets (title, description, language, tags) VALUES (?, ?, ?, ?);");
			if($query->execute(array($title, $description, $language, $tags))){
				return $this->pdo->lastInsertId();
			}else{
				\ShitHub\Core\Loader::getLogger()->alert('SQL Error: '.$query->queryString.': '.$query->errorInfo()[2]);
			}
		}//TODO: Handle if pdo is null
	}

	public function load_snippet($id){
		if($this->pdo != null){
			$query = $this->pdo->prepare("SELECT title, description, language, tags FROM snippets WHERE id = ?");
			$query->execute(array($id));
			$row = $query->fetch();
			
			return $row;
		}//TODO: Handle if pdo is null
	}

	public function get_unresponded_reviews(int $anz){
		if($this->pdo != null){
			$query = $this->pdo->prepare("SELECT author_id, author_name, title, language, tags FROM snippets LIMIT :limit"); //TODO: implement state 
			$query->bindParam(':limit', $anz, \PDO::PARAM_INT);
			$query->execute();

			$array = array();
			while($row = $query->fetch()){
				array_push($array, $row);
			}
			return $array;
		}//TODO: Handle if pdo is null
	}

	public function get_last_Review(int $anz){
		if($this->pdo != null){
			$query = $this->pdo->prepare("SELECT  author_id, author_name, title, language, tags FROM snippets LIMIT :limit"); //TODO: implement state 
			$query->bindParam(':limit', $anz, \PDO::PARAM_INT);
			$query->execute();

			$array = array();
			while($row = $query->fetch()){
				array_push($row, $array);
			}

			return $array;
		}//TODO: Handle if pdo is null
	}
}