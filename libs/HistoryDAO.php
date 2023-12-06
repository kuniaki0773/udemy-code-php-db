<?php

class HistoryDAO
{
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function insert($account_id, $section_id)
    {
        $sql = "insert into histories (account_id, section_id) 
                    values (:account_id, :section_id)";
        $ps = $this->pdo->prepare($sql);
        $ps->bindValue(":account_id", $account_id, PDO::PARAM_INT);
        $ps->bindValue(":section_id", $section_id, PDO::PARAM_INT);
        $ps->execute();
    }

    public function selectByAccountId($account_id)
    {
        $sql = "select 
                    c.id course_id, 
                    c.title course_title, 
                    s.id section_id, 
                    s.title section_title, 
                    s.no section_no, 
                    h.created_at 
                from 
                    histories h 
                    inner join sections s on h.section_id = s.id 
                    inner join courses c on s.course_id = c.id 
                where 
                    account_id = :account_id
                order by
                    h.created_at desc";
        $ps = $this->pdo->prepare($sql);
        $ps->bindValue(":account_id", $account_id, PDO::PARAM_INT);
        $ps->execute();
        $histories = $ps->fetchAll();
        return $histories;
    }
}