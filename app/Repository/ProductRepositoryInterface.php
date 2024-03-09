<?php


namespace App\Repository;


interface ProductRepositoryInterface
{
    public function index();

    public function show($id);

    public function store($r);

    public function update($r);

    public function destroy($r);

}