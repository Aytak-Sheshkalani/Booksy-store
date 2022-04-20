<?php
	
	function select4LatestBook($conn){
		$row = array();
		$query = "SELECT book_isbn, book_image FROM books ORDER BY book_isbn DESC";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Can't retrieve data " . mysqli_error($conn);
		    exit;
		}
		for($i = 0; $i < 4; $i++){
			array_push($row, mysqli_fetch_assoc($result));
		}
		return $row;
	}

	function getBookByIsbn($conn, $isbn){
		$query = "SELECT Title, AuthorID, Price FROM Book WHERE ISBN = '$isbn'";
		$result = mysqli_query($conn, $query);
		if(!$result){
			echo "Can't retrieve data " . mysqli_error($conn);
			exit;
		}
		return $result;
	}

	

	

	function getbookprice($isbn){
		$conn = db_connect();
		$query = "SELECT Price FROM books WHERE ISBN = '$isbn'";
		$result = mysqli_query($conn, $query);
		if(!$result){
			echo "get book price failed! " . mysqli_error($conn);
			exit;
		}
		$row = mysqli_fetch_assoc($result);
		return $row['Price'];
	}







	function getAll($conn){
		$query = "SELECT * from Book ORDER BY ISBN DESC";
		$result = mysqli_query($conn, $query);
		if(!$result){
			echo "Can't retrieve data " . mysqli_error($conn);
			exit;
		}
		return $result;
	}
?>