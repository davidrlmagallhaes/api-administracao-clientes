<?php

interface ClienteRepository {
    public function getAll();
    public function getById($id);
    public function save($data);
    public function update($id, $data);
    public function delete($id);
}
