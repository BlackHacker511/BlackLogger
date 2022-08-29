<?php

namespace Framework;

class Client
{
    /**
     * Database Connection
     *
     * @var Database
     */
    private $db;

    /**
     * Utils Connection
     *
     * @var Utils
     */
    private $utils;

    /**
     * Clients class constructor
     *
     * @param object $database
     *  An object from the Database class
     * @param object $utils
     *  An object from the Utils class
     * @return void
     */
    public function __construct($database, $utils)
    {

        $this->db = $database;

        $this->utils = $utils;
    }

    /**
     * Create a new client
     *
     * @param array $clientdata
     *  An array contains the client data such as HWID and IP Address
     * @return bool
     *  Return true if the client is added to the database without issues
     */
    public function newClient($clientdata)
    {
        $new_client_syntax = "INSERT INTO clients (%s) VALUES (%s)";

        if ($this->isExist($clientdata['ip_address'], "clients")) {
            if ($this->updateClient($clientdata)) {
                return true;
            }
        }

        $this->db->query(sprintf(
            $new_client_syntax,
            implode(", ", array_keys($clientdata)),
            ":" . implode(",:", array_keys($clientdata))
        ));

        foreach ($clientdata as $key => $value) {
            $this->db->bind(":" . $key, $value, \PDO::PARAM_STR);
        }

        return $this->db->execute();
    }

    /**
     * Update the client information with a new one
     *
     * @param array $clientdata
     *  The new client data to update an existing client in the database
     * @return bool
     *  Return true if the client is updated in the database
     */
    public function updateClient($clientdata)
    {
        $update_client_syntax = "UPDATE clients SET %s WHERE ip_address = :ip_address";

        $sql_values = "";

        foreach ($clientdata as $key => $value) {
            $sql_values .= "$key=:$key, ";
        }

        $sql_values = rtrim($sql_values, ", ");

        $sql = sprintf($update_client_syntax, $sql_values);

        $this->db->query($sql);

        foreach ($clientdata as $key => $value) {
            $this->db->bind(":" . $key, $value);
        }

        return $this->db->execute();
    }

    /**
     * Check if a client exist
     *
     * @param string $clientID
     *  A client id must be a string, like HacKed_123456
     * @param string $table_name
     *  Table name to check if client exists in them like logs, commands, or clients
     * @return bool
     *  Return true if the client exsit else if the client does not exist
     */
    public function isExist($clientID, $table_name)
    {
        $this->db->query(sprintf("SELECT * FROM %s WHERE ip_address = :id", $table_name));

        $this->db->bind(':id', $clientID, \PDO::PARAM_STR);

        if ($this->db->execute()) {
            return $this->db->rowCount() ? true : false;
        }
    }

    /**
     * Get all clients from database
     *
     * @return array
     *  Return an array that contains all the clients that are in the database
     */
    public function getClients()
    {
        $this->db->query("SELECT * FROM clients");

        if ($this->db->execute()) {
            return $this->db->resultset();
        }
    }

    /**
     * Count all clients
     *
     * @return int
     *  Return an integer that represents the number of clients in the database
     */
    public function countClients()
    {
        $this->db->query("SELECT * FROM clients");
        if ($this->db->execute()) {
            return $this->db->rowCount();
        }
    }

    /**
     * Get the client information from the database using vicid
     *
     * @param string $vicID
     *  A client id must be a string, like HacKed_123456
     * @return object|bool
     *  Return an object that contains the selected client data or false
     */
    public function getClient($ip_address)
    {
        $this->db->query("SELECT * FROM clients WHERE ip_address = :id");

        $this->db->bind(":id", $ip_address, \PDO::PARAM_STR);

        if ($this->db->execute()) {
            return $this->db->single();
        }

        return false;
    }

    /**
     * Count the number of clients using a condition
     *
     * @param string $column_name
     *  The column name in the database such as os or insdata
     * @param string $cond
     *  The condition that you want to count the number of clients based on it
     * @return int
     *  Return integer that represents the number of clients
     */
    public function countClientsByCond($column_name, $cond)
    {
        $this->db->query(sprintf("SELECT * FROM clients WHERE %s = :cond", $column_name));

        $this->db->bind(":cond", $cond, \PDO::PARAM_STR);

        if ($this->db->execute()) {
            return $this->db->rowCount();
        }
    }

    /**
     * Select a specific piece of information from the clients table
     *
     * @param string $column_name
     *  The column name that contains the information you want to retrieve
     * @return array
     *  Returns an array contains the information from all the existing clients
     */
    public function selectInfoFromClients($column_name)
    {
        $sql = sprintf("SELECT %s FROM clients", $column_name);

        $this->db->query($sql);

        if ($this->db->execute()) {
            return $this->db->resultset();
        }
    }



    /**
     * Get all logs from the database
     *
     * @return array
     *  Return an array that contains all the system logs
     */
    public function getLogs()
    {
        $this->db->query("SELECT * FROM logs");

        if ($this->db->execute()) {
            return $this->db->resultset();
        }
    }

    /**
     * Get the client flag name from a country code
     *
     * @param string $code
     *  An ISO 3166-1 alpha-2 two letters country code
     * @return string
     *  Return the flag image path for the country
     */
    public function getClientFlag($code)
    {
        $countries = $this->utils->getCountries();

        $flag = "";

        if (
            $countries[strtoupper($code)] == "Unknown" ||
            !array_key_exists(strtoupper($code), $countries)
        ) {
            $flag = "X";
        }

        $flag = $code;

        return sprintf("assets/flags/%s.png", $flag);
    }
}
