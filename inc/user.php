<?php
require_once 'db_config.php';

class User extends DB_Config
{
    public $db;
    public function __construct()
    {
        // membuat koneksi dengan database
        $this->db = new mysqli(
            $this->db_host,
            $this->db_username,
            $this->db_password,
            $this->db_name
        );
        // cek koneksi
        if ($this->db->connect_errno) {
            printf("Koneksi gagal: %s\n", $this->db->connect_error);
            exit();
        }
    }

    /*
      melakukan permintaan ambil data yg ada dalam database
      @parameter table ~> nama tabel dalam database
      @parameter condition ~> aturan permintaan data
    */
    public function getRows($table, $condition = array())
    {
        $sql = 'SELECT';
        $sql .= array_key_exists("select", $condition) ? $condition['select'] : '*';
        $sql .= ' FROM ' . $table;

        if (array_key_exists("where", $condition)) {
            $sql .= ' WHERE ';
            $i = 0;     // nilai awal data 
            foreach ($condition['where'] as $key => $value) {
                $pre = ($i > 0) ? ' AND ' : '';
                $sql .= $pre . $key . " = '" . $value . "'";
                $i++;
            }
        }

        if (array_key_exists("order_by", $condition)) {
            $sql .= ' ORDER BY ' . $condition['order_by'];
        } else {
            $sql .= ' ORDER BY id DESC ';
        }

        if (
            array_key_exists("start", $condition) &&
            array_key_exists("limit", $condition)
        ) {
            $sql .= ' LIMIT ' . $condition['start'] . ',' . $condition['limit'];
        } elseif (
            !array_key_exists("start", $condition) &&
            array_key_exists("limit", $condition)
        ) {
            $sql .= ' LIMIT ' . $condition['limit'];
        }

        $result = $this->db->query($sql);

        if (
            array_key_exists("return_type", $condition) &&
            $condition['return_type'] != 'all'
        ) {
            switch ($condition['return_type']) {
                case 'count':
                    $data = $result->num_rows;
                    break;
                case 'single':
                    $data = $result->fetch_assoc();
                    break;
                default:    // kalau tidak ada data
                    $data = '';
            }
        } else {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }
        }
        return !empty($data) ? $data : false;
    }

    /* 
      memasukkan data kedalam database / insert 
      @parameter table ~> nama tabel dalam database
      @parameter data ~> data yang akan dimasukkan kedalam database
    */
    public function insert($table, $data)
    {
        if (!empty($data) && is_array($data)) {
            $columns = '';
            $values = '';
            $i = 0;     // nilai awal 

            if (!array_key_exists('created', $data)) {
                $data['created'] = date("Y-m-d H:i:s");
            }
            if (!array_key_exists('modified', $data)) {
                $data['modified'] = date("Y-m-d H:i:s");
            }

            foreach ($data as $key => $val) {
                $pre = ($i > 0) ? ', ' : '';
                $columns .= $pre . $key;
                $values .= $pre . "'" . $this->db->real_escape_string($val) . "'";
                $i++;
            }

            // perintah query untuk insert data
            $query = "INSERT INTO " . $table . " (" . $columns . ") VALUES (" . $values . ")";
            $insert = $this->db->query($query);
            return $insert ? $this->db->insert_id : false;
        } else {
            return false;
        }
    }

    /*
      mengubah isi data dalam database / update
      @parameter table ~> nama tabel dalam database
      @parameter data ~> data yang akan diubah isinya
      @parameter condition ~> aturan permintaan data yang akan diubah
    */
    public function update($table, $data, $condition)
    {
        if (!empty($data) && is_array($data)) {
            $colvalSet = '';
            $whereSql = '';
            $i = 0;     // nilai awal 

            if (!array_key_exists('modified', $data)) {
                $data['modified'] = date("Y-m-d H:i:s");
            }

            foreach ($data as $key => $val) {
                $pre = ($i > 0) ? ', ' : '';
                $colvalSet .= $pre . $key . "='" . $this->db->real_escape_string($val) . "'";
                $i++;
            }

            if (!empty($condition) && is_array($condition)) {
                $whereSql .= ' WHERE ';
                $i = 0;
                foreach ($condition as $key => $value) {
                    $pre = ($i > 0) ? ' AND ' : '';
                    $whereSql .= $pre . $key . " = '" . $value . "'";
                    $i++;
                }
            }

            // perintah query untuk update data
            $query = "UPDATE " . $table . " SET " . $colvalSet . $whereSql;
            $update = $this->db->query($query);
            return $update ? $this->db->affected_rows : false;
        } else {
            return false;
        }
    }
}
