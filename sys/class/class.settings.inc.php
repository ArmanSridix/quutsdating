<?php

/*!
 * https://raccoonsquare.com
 * raccoonsquare@gmail.com
 *
 * Copyright 2012-2022 Demyanchuk Dmitry (raccoonsquare@gmail.com)
 */

class settings extends db_connect
{
	private $requestFrom = 0;
    private $id = 0;

	public function __construct($dbo = NULL)
    {
		parent::__construct($dbo);

        // off all pdo errors when column in table exists

        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
	}

    public function getCount()
    {
        $stmt = $this->db->prepare("SELECT count(*) FROM admins");
        $stmt->execute();

        return $number_of_rows = $stmt->fetchColumn();
    }

    public function createValue($name, $intValue, $textValue = "")
    {

        $result = array(
            "error" => true,
            "error_code" => ERROR_UNKNOWN
        );

        $stmt = $this->db->prepare("INSERT INTO settings (name, intValue, textValue) value (:name, :intValue, :textValue)");
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":intValue", $intValue, PDO::PARAM_INT);
        $stmt->bindParam(":textValue", $textValue, PDO::PARAM_STR);

        if ($stmt->execute()) {

            $result = array(
                "error" => false,
                "error_code" => ERROR_SUCCESS
            );

            return $result;
        }

        return $result;
    }

    public function setValue($name, $intValue, $textValue = "")
    {
        $stmt = $this->db->prepare("UPDATE settings SET intValue = (:intValue), textValue = (:textValue) WHERE name = (:valueName)");
        $stmt->bindParam(":valueName", $name, PDO::PARAM_STR);
        $stmt->bindParam(":intValue", $intValue, PDO::PARAM_INT);
        $stmt->bindParam(":textValue", $textValue, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function getIntValue($name)
    {
        $stmt = $this->db->prepare("SELECT intValue FROM settings WHERE name = (:valueName) LIMIT 1");
        $stmt->bindParam(":valueName", $name, PDO::PARAM_STR);

        if ($stmt->execute()) {

            $row = $stmt->fetch();

            return $row['intValue'];
        }

        return 0;
    }

    public function getTextValue($name)
    {
        $stmt = $this->db->prepare("SELECT textValue FROM settings WHERE name = (:valueName) LIMIT 1");
        $stmt->bindParam(":valueName", $name, PDO::PARAM_INT);

        if ($stmt->execute()) {

            $row = $stmt->fetch();

            return $row['textValue'];
        }

        return "";
    }

    public function deleteValue($name)
    {
        $stmt = $this->db->prepare("DELETE FROM settings WHERE name = (:valueName)");
        $stmt->bindParam(":valueName", $name, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function get()
    {
        $result = array("error" => false,
                        "error_code" => ERROR_SUCCESS);

        $stmt = $this->db->prepare("SELECT * FROM settings");

        if ($stmt->execute()) {

            while ($row = $stmt->fetch()) {

                $result[$row['name']] = array("error" => false,
                                              "error_code" => ERROR_SUCCESS,
                                              "id" => $row['id'],
                                              "name" => $row['name'],
                                              "textValue" => $row['textValue'],
                                              "intValue" => $row['intValue']);
            }
        }

        return $result;
    }

    public function setId($accountId)
    {
        $this->id = $accountId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setRequestFrom($requestFrom)
    {
        $this->requestFrom = $requestFrom;
    }

    public function getRequestFrom()
    {
        return $this->requestFrom;
    }


    public function db_getMaxId()
    {
        $stmt = $this->db->prepare("SELECT MAX(id) FROM subscription_package");
        $stmt->execute();

        return $number_of_rows = $stmt->fetchColumn();
    }

    public function db_get($itemId = 0, $limit = 100)
    {
        if ($itemId == 0) {

            $itemId = $this->db_getMaxId();
            $itemId++;
        }

        $items = array("error" => false,
                       "error_code" => ERROR_SUCCESS,
                       "itemId" => $itemId,
                       "items" => array());

        $stmt = $this->db->prepare("SELECT * FROM subscription_package  AND id < (:packageId) ORDER BY id DESC LIMIT :limit");
        $stmt->bindParam(':packageId', $itemId, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);

        if ($stmt->execute()) {

            while ($row = $stmt->fetch()) {

                $itemInfo = array("error" => false,
                                  "error_code" => ERROR_SUCCESS,
                                  "id" => $row['id'],
                                  "package_name" => $row['package_name'],
                                  "package_price" => $row['package_price'],
                                  "package_connects" => $row['package_connects'],
                                  "package_duration" => $row['package_duration']);
                                //   "date" => date("Y-m-d H:i:s", $row['createAt']),
                                //   "removeAt" => $row['removeAt'])
                                  

                array_push($items['items'], $itemInfo);

                $items['itemId'] = $itemInfo['id'];

                unset($itemInfo);
            }
        }

        return $items;
    }
}

