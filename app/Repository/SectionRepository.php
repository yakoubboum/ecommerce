<?php


namespace App\Repository;

use App\Models\Section;
use App\Repository\SectionRepositoryInterface;







class SectionRepository implements SectionRepositoryInterface
{

    public function index()
    {
        $Sections = Section::all();
        return \view('Dashboard.Sections.index', \compact('Sections'));
    }

    public function getproducts($id)
    {
        $data = Section::findOrfail($id)->products()->orderBy('created_at', 'desc')->get();

        $sections=Section::all();
        return \view('Dashboard.Products.index', \compact('data', 'sections'));

    }
    public function show($id)
    {
    }
    public function store($r)
    {

        return $r;
        session()->flash('add');
        return back();
    }

    public function update($request)
    {

        // $request->validate([
        //     'name' => 'required|unique:section_translations,name,' . $request->input('name') . ',' . (
        //         $request->has('id') ? 'section_id,' . $request->input('id') : ''
        //     ),
        // ]);

        $section = Section::findOrFail($request->id);
        $section->update([
            'name' => $request->input('name'),
        ]);
        session()->flash('edit');
        return redirect()->route('sections.index');
    }

    public function destroy($request)
    {
        Section::findOrFail($request->id)->delete();
        session()->flash('delete');
        return redirect()->route('sections.index');
    }
}
