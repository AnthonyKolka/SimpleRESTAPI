<?php
abstract class base_controller
{
    public function DELETE()
    {
        exit;
    }
    public function GET()
    {
        exit;
    }
    public function PATCH()
    {
        exit;
    }
    public function POST()
    {
        exit;
    }
    public function PUT()
    {
        exit;
    }

    public $data;
    protected $config;
    protected $db;
    public function __construct($data, $config)
    {
        $this->data = $data;
        $this->config = $config;
        $this->db = $this->config['db'];
    }
}
?>