<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Paymentspp_model extends CI_Model{

	function ViewGetSPP(){
		return $this->db->get('m_paymentspp');
	}	


	function ViewGetCardSPP($schoolx="", $studentx=""){
		return $this->db->query("
								SELECT  a.monthid, a.monthname, b.paymentid, b.schoolyear, b.studentid, b.totalpaid, 
                                        b.lastupdateby, b.lastupdatedate, b.dateofbirth, b.gender, b.nominalamount, b.studentname, b.classid
                                FROM    m_mastermonth a
                                LEFT    JOIN
                                          (
                                            SELECT  x.studentid, x.schoolyear, x.paymentid, x.totalpaid, x.isactive, x.monthid, 
                                                    x.lastupdateby, x.lastupdatedate, y.dateofbirth, y.gender, v.nominalamount, y.studentname, y.classid
                                            FROM    m_paymentspp x
                                            INNER   JOIN m_student y on x.studentid=y.studentid and x.schoolyear=y.schoolyear
                                            INNER   JOIN m_nominalpayment v on y.classid=v.classid and y.schoolyear=v.schoolyear
                                            WHERE   x.schoolyear = '".$schoolx."'
                                                    AND x.studentid = '".$studentx."' 
                                          )
                                          b on a.monthid=b.monthid and b.isactive ='Y'
                                WHERE   a.isactive='Y'
                                ORDER   BY a.monthid
								");
	}	
}

?>