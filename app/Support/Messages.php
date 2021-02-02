<?php

namespace App\Support;

class Messages
{
    private $text;
    private $type;

    public function getText()
    {
        return $this->text;
    }

    public function getType()
    {
        return $this->type;
    }

    public function success(string $message): Messages
    {
        $this->type = 'success';
        $this->text = $message;
        return $this;
    }

    public function error(string $message): Messages
    {
        $this->type = 'danger';
        $this->text = $message;
        return $this;
    }

    public function info(string $message): Messages
    {
        $this->type = 'primary';
        $this->text = $message;
        return $this;
    }

    public function warning(string $message): Messages
    {
        $this->type = 'warning';
        $this->text = $message;
        return $this;
    }

    public function render()
    {
        return "<div class='alert alert-{$this->getType()}'>{$this->getText()}</div>";
    }
}
