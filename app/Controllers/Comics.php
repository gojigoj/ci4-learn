<?php

namespace App\Controllers;

use App\Models\ComicsModel;

class Comics extends BaseController
{

  protected $comicsModel;

  public function __construct()
  {
    $this->comicsModel = new ComicsModel();
  }

  public function index()
  {

    $data = [
      'title' => 'Daftar Komik',
      'comics' => $this->comicsModel->getComic()
    ];


    return view('comics/index', $data);
  }

  public function detail($slug)
  {
    $comic = $this->comicsModel->getComic($slug);
    $data = [
      'title' => 'Comic Detail',
      'comic' => $comic
    ];

    if (empty($data['comic'])) {
      throw new \CodeIgniter\Exceptions\PageNotFoundException('Comic ' . $slug . ' not found');
    }

    return view('comics/detail', $data);
  }

  public function create()
  {

    $data = [
      'title' => 'Form add new comic',
      'validation' => \Config\Services::validation()
    ];

    return view('comics/create', $data);
  }

  public function save()
  {

    if (!$this->validate([
      'title' => [
        'rules' => 'required|is_unique[comics.title]',
        'errors' => [
          'required' => 'Comic {field} is required.',
          'is_unique' => 'Comic {field} is already in database'
        ]
      ],
      'cover' => [
        'rules' => 'max_size[cover,1024]|is_image[cover]|mime_in[cover,image/jpg,image/jpeg,image/png]|',
        'errors' => [
          'max_size' => 'Image size is too big.',
          'is_image' => 'File must be image.',
          'mime_in' => 'File must be image.'
        ]
      ]
    ])) {
      // $validation = \Config\Services::validation();
      // return redirect()->to('/comics/create')->withInput()->with('validation', $validation);
      return redirect()->to('/comics/create')->withInput();
    }

    // get image
    $fileCover = $this->request->getFile('cover');

    if ($fileCover->getError() == 4) {
      $coverName = 'default.png';
    } else {
      // generete random name
      $coverName = $fileCover->getRandomName();
      // move to img folder
      $fileCover->move('img', $coverName);
    }


    $slug = url_title($this->request->getVar('title'), '-', true);
    $this->comicsModel->save([
      'title' => $this->request->getVar('title'),
      'slug' => $slug,
      'author' => $this->request->getVar('author'),
      'publisher' => $this->request->getVar('publisher'),
      'cover' => $coverName
    ]);

    session()->setFlashdata('pesan', 'Data berhasil ditambahkan');

    return redirect()->to('/comics');
  }

  public function delete($id)
  {

    // get comic data
    $comic = $this->comicsModel->find($id);

    if ($comic['cover'] != 'default.png') {
      // delete image
      unlink('img/' . $comic['cover']);
    }

    $this->comicsModel->delete($id);

    session()->setFlashdata('pesan', 'Data berhasil dihapus');
    return redirect()->to('/comics');
  }

  public function edit($slug)
  {
    $data = [
      'title' => 'Form edit comic',
      'validation' => \Config\Services::validation(),
      'comic' => $this->comicsModel->getComic($slug)
    ];

    return view('comics/edit', $data);
  }

  public function update($id)
  {
    $oldComic = $this->comicsModel->getComic($this->request->getVar('slug'));
    if ($oldComic['title'] == $this->request->getVar('title')) {
      $title_rules = 'required';
    } else {
      $title_rules = 'required|is_unique[comics.title]';
    }

    if (!$this->validate([
      'title' => [
        'rules' => $title_rules,
        'errors' => [
          'required' => 'Comic {field} si required.',
          'is_unique' => 'Comic {field} is already in database'
        ],
        'cover' => [
          'rules' => 'max_size[cover,1024]|is_image[cover]|mime_in[cover,image/jpg,image/jpeg,image/png]|',
          'errors' => [
            'max_size' => 'Image size is too big.',
            'is_image' => 'File must be image.',
            'mime_in' => 'File must be image.'
          ]
        ]
      ]
    ])) {
      // $validation = \Config\Services::validation();
      // return redirect()->to('/comics/edit/' . $this->request->getVar('slug'))->withInput()->with('validation', $validation);
      return redirect()->to('/comics/edit/' . $this->request->getVar('slug'))->withInput();
    }

    $fileCover = $this->request->getFile('cover');

    if ($fileCover->getError() == 4) {
      $coverName = $this->request->getVar('oldCover');
    } else {
      // generete random name
      $coverName = $fileCover->getRandomName();
      // move to img folder
      $fileCover->move('img', $coverName);
      // delete oldCOver
      unlink('img/' . $this->request->getVar('oldCover'));
    }

    $slug = url_title($this->request->getVar('title'), '-', true);
    $this->comicsModel->save([
      'id' => $id,
      'title' => $this->request->getVar('title'),
      'slug' => $slug,
      'author' => $this->request->getVar('author'),
      'publisher' => $this->request->getVar('publisher'),
      'cover' => $coverName
    ]);

    session()->setFlashdata('pesan', 'Data berhasil diubah');

    return redirect()->to('/comics');
  }
}
