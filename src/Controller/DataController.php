<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DataController extends AbstractController
{
    #[Route('/', name: 'SHOW_VALUE')]
    public function showValue(): Response
    {
        $value = $this->getPairs();

        return $this->render('data.html.twig', [
            'value' => $value,
        ]);
    }

    public function getDataFromFile(): array
    {
        $file = file_get_contents('/home/noa/PhpstormProjects/AdventsOfCode/Day4/src/data.txt');

        return explode("\n", $file);
    }

    public function isolateFirstData(): array
    {
        $file = $this->getDataFromFile();
        $firstData = [];

        foreach ($file as $key => $value) {
            $firstData[$key] = strtok($value, ',');
        }

        return $firstData;
    }

    public function isolateLastData(): array
    {
        $file = $this->getDataFromFile();
        $lastData = [];

        foreach ($file as $key => $value) {
            $lastData[$key] = substr($value, strpos($value, ",") + 1);
        }

        return $lastData;
    }

    public function getPairs(): int
    {
        $file = $this->getDataFromFile();
        $firstData = $this->isolateFirstData();
        $lastData = $this->isolateLastData();
        $sum = 0;

        foreach ($file as $key => $value) {
            $diffFirstArray = (substr($firstData[$key], strpos($firstData[$key], "-") + 1) - strtok($firstData[$key], '-'));
            $diffLastArray = (substr($lastData[$key], strpos($lastData[$key], "-") + 1) - strtok($lastData[$key], '-'));

            $firstValueElf1 = strtok($firstData[$key], '-');
            $lastValueElf1 = substr($firstData[$key], strpos($firstData[$key], "-") + 1);
            $firstValueElf2 = strtok($lastData[$key], '-');
            $lastValueElf2 = substr($lastData[$key], strpos($lastData[$key], "-") + 1);

            if ($diffFirstArray > $diffLastArray) {
                $biggestDiff = [$firstValueElf1, $lastValueElf1];
                $smallestDiff = [$firstValueElf2, $lastValueElf2];
            } else {
                $biggestDiff = [$firstValueElf2, $lastValueElf2];
                $smallestDiff = [$firstValueElf1, $lastValueElf1];
            }

            if ($smallestDiff[0] >= $biggestDiff[0] && $smallestDiff[1] <= $biggestDiff[1]) {
                $sum += 1;
            }
        }

        return $sum;
    }
}