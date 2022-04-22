<?php
// Incluimos nuestra clase Conexión.
// We include our Connection class.
require_once('./connection/connection.class.php');
// Creamos la clase Cliente.
// We create the Client class.
class Cliente
{
    // Método obtener todos los clientes.
    // Method get all clients.
    public static function getAllClients()
    {
        $data = [];
        $query = 'SELECT * FROM clientes';
        try {
            $stmt = Connection::connect()->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                $data[] = $row;
            }
            return $data;
            Connection::disconnect();
        } catch (PDOException $e) {
            die($e->getMessage());
            return $data;
            Connection::disconnect();
        }
    }
    // Método obtener cliente por id.
    // Method get client by id.
    public static function getClientWhere($cliente_id)
    {
        $data = [];
        $query = 'SELECT * FROM clientes WHERE cliente_id = :n1';
        try {
            $stmt = Connection::connect()->prepare($query);
            $stmt->bindParam(':n1', $cliente_id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                $data[] = $row;
            }
            return $data;
            Connection::disconnect();
        } catch (PDOException $e) {
            die($e->getMessage());
            return $data;
            Connection::disconnect();
        }
    }
    // Método agregar cliente.
    // Method add client.
    public static function addClient($cliente_nombre, $cliente_apepat, $cliente_apemat, $cliente_fnacimiento, $cliente_genero)
    {
        $query = 'INSERT INTO clientes(cliente_nombre, cliente_apepat, cliente_apemat, cliente_fnacimiento, cliente_genero) VALUES (:n1, :n2, :n3, :n4, :n5);';
        try {
            $stmt = Connection::connect()->prepare($query);
            $stmt->bindParam(':n1', $cliente_nombre, PDO::PARAM_STR);
            $stmt->bindParam(':n2', $cliente_apepat, PDO::PARAM_STR);
            $stmt->bindParam(':n3', $cliente_apemat, PDO::PARAM_STR);
            $stmt->bindParam(':n4', $cliente_fnacimiento, PDO::PARAM_STR);
            $stmt->bindParam(':n5', $cliente_genero, PDO::PARAM_STR);
            $stmt->execute();
            return true;
            Connection::disconnect();
        } catch (PDOException $e) {
            die($e->getMessage());
            return false;
            Connection::disconnect();
        }
    }
    // Método actualizar cliente.
    // Update client method.
    public static function updateClient($cliente_nombre, $cliente_apepat, $cliente_apemat, $cliente_fnacimiento, $cliente_genero, $cliente_id)
    {
        $query = 'UPDATE clientes SET cliente_nombre = :n1, cliente_apepat = :n2, cliente_apemat = :n3, cliente_fnacimiento = :n4, cliente_genero = :n5 WHERE cliente_id = :n6;';
        try {
            $stmt = Connection::connect()->prepare($query);
            $stmt->bindParam(':n1', $cliente_nombre, PDO::PARAM_STR);
            $stmt->bindParam(':n2', $cliente_apepat, PDO::PARAM_STR);
            $stmt->bindParam(':n3', $cliente_apemat, PDO::PARAM_STR);
            $stmt->bindParam(':n4', $cliente_fnacimiento, PDO::PARAM_STR);
            $stmt->bindParam(':n5', $cliente_genero, PDO::PARAM_STR);
            $stmt->bindParam(':n6', $cliente_id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
            Connection::disconnect();
        } catch (PDOException $e) {
            die($e->getMessage());
            return false;
            Connection::disconnect();
        }
    }
    // Método eliminar cliente.
    // Delete client method.
    public static function deleteClient($cliente_id)
    {
        $query = 'DELETE FROM clientes WHERE cliente_id = :n1';
        try {
            $stmt = Connection::connect()->prepare($query);
            $stmt->bindParam(':n1', $cliente_id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
            Connection::disconnect();
        } catch (PDOException $e) {
            die($e->getMessage());
            return false;
            Connection::disconnect();
        }
    }
}
?>