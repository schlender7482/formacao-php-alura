<?php

namespace Alura\Pdo\Domain\Model;

class Phone
{
    private ?int $id;
    private string $number;
    private string $areaCode;

    public function __construct(?int $id, string $areaCode, string $number)
    {
        $this->id = $id;
        $this->number = $number;
        $this->areaCode = $areaCode;
    }

    public function formattedPhone(): string
    {
        return "($this->areaCode) $this->number";
    }
}