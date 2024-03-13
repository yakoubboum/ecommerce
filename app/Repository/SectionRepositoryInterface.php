<?php


namespace App\Repository;


interface SectionRepositoryInterface
{
    public function index();

    public function show($id);

    public function store($r);

    public function update($request);

    public function destroy($request);

    public function getproducts($id);

}