<?php namespace Zbw\Training\Contracts;

interface TrainingGraderInterface
{
    public function __construct(Array $input);
    public function fileReport();
}
