<?php

include_once(dirname(dirname(__FILE__)) . "/mysql.php");

/**
 * Classe utilizada para armazenar dados do banco de dados
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class Database extends MySQL
{
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function Database()
	{
		//parent::MySQL("187.45.196.243", "camarasjcsp2", "cAM.sjC298", "camarasjcsp2");
		//parent::MySQL("186.202.152.131", "camarasjc21", "dsz5422s@m", "camarasjc21");

        parent::MySQL("localhost", "root", "", "cmsjc2015");
	}
}

?>