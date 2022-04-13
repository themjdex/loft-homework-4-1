<?php

interface IServicePrice
{
    public function getSum();
    public function putNewService($idService);
}

interface IOptionalService
{
    public function getSumOptionalService();
}

abstract class Rate implements IServicePrice, IOptionalService
{
    public int $gps;
    public int $driver;
    public int $kms;
    public int $minutes;

    public function __construct($kms, $minutes, $gps = false, $driver = false)
    {
        $this->kms = $kms;
        $this->minutes = $minutes;

        if ($gps) {
            $this->putNewService(1);
        } else {
            $this->gps = 0;
        }
        if ($driver) {
            $this->putNewService(2);
        } else {
            $this->driver = 0;
        }
    }

    abstract public function getSum();

    public function putNewService($idService)
    {
        if ($idService === 1) {
            $this->gps = 15;
        } elseif ($idService === 2) {
            $this->driver = 100;
        }
    }
    public function getSumOptionalService()
    {
        return ceil($this->minutes / 60) * $this->gps + $this->driver;
    }
}

class Basic extends Rate
{
    public string $rate = 'Базовый';
    public int $sumKm = 10;
    public int $sumMinute = 3;
    public int $gps;
    public int $driver;
    public int $kms;
    public int $minutes;

    public function getSum()
    {
        $result = $this->getSumOptionalService() + $this->kms * $this->sumKm + $this->minutes * $this->sumMinute;
        echo 'Тариф ' . $this->rate . "($this->kms км, $this->minutes мин)" . '<br>';
        if ($this->gps != 0) {
            echo '- добавить услугу GPS' . '<br>';
        }
        if ($this->driver != 0) {
            echo '- добавить услугу дополнительного водителя' . '<br>';
        }
        echo 'Итого: ' . $result;
    }
}

class PerHour extends Rate
{
    public string $rate = 'Почасовой';
    public int $sumKm = 0;
    public int $sumHour = 200;
    public int $gps;
    public int $driver;
    public int $kms;
    public int $minutes;
    public int $hours;

    public function getSum()
    {
        $this->hours = ceil($this->minutes / 60);

        $result = $this->getSumOptionalService() + $this->kms * $this->sumKm + $this->hours * $this->sumHour;

        echo 'Тариф ' . $this->rate . "($this->kms км, $this->minutes мин)" . '<br>';
        if ($this->gps != 0) {
            echo '- добавить услугу GPS' . '<br>';
        }
        if ($this->driver != 0) {
            echo '- добавить услугу дополнительного водителя' . '<br>';
        }
        echo 'Итого: ' . $result;
    }

}

class ForStudents extends Rate
{
    public string $rate = 'Студенческий';
    public int $sumKm = 4;
    public int $sumMinute = 1;
    public int $gps;
    public int $driver;
    public int $kms;
    public int $minutes;

    public function getSum()
    {
        $result = $this->getSumOptionalService() + $this->kms * $this->sumKm + $this->minutes * $this->sumMinute;
        echo 'Тариф ' . $this->rate . "($this->kms км, $this->minutes мин)" . '<br>';
        if ($this->gps != 0) {
            echo '- добавить услугу GPS' . '<br>';
        }
        if ($this->driver != 0) {
            echo '- добавить услугу дополнительного водителя' . '<br>';
        }
        echo 'Итого: ' . $result;
    }

}

$travel = new Basic(10, 4000, false, true);
$travel->getSum();
echo '<br><br>';
$travel2 = new PerHour(10, 10, false, false);
$travel2->getSum();
echo '<br><br>';
$travel3 = new ForStudents(111, 157, true, false);
$travel3->getSum();