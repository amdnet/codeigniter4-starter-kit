<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        if (auth()->user()->inGroup('admin')) {
            return redirect()->to('admin');
        } elseif (auth()->user()->inGroup('klien')) {
            return redirect()->to('klien');
        } else {
            return redirect()->to('login');
        }
    }

    public function lihat()
    {
        // var_dump(cache('cache_setting'));
        // $data = 'a:3:{s:4:"time";i:1759804912;s:3:"ttl";i:0;s:4:"data";a:1:{s:10:"Config\App";a:33:{s:16:"authRegistration";a:2:{s:5:"value";s:5:"false";s:4:"type";s:7:"boolean";}s:13:"authMagicLink";a:2:{s:5:"value";s:5:"false";s:4:"type";s:7:"boolean";}s:15:"authRemembering";a:2:{s:5:"value";s:4:"true";s:4:"type";s:7:"boolean";}s:18:"authRememberLength";a:2:{s:5:"value";s:7:"2592000";s:4:"type";s:6:"string";}s:10:"gRecaptcha";a:2:{s:5:"value";s:5:"false";s:4:"type";s:7:"boolean";}s:8:"gSiteKey";a:2:{s:5:"value";s:40:"6LfZjAYTAAAAALned7hcZ5nGuiqIgEMs3rffDF5w";s:4:"type";s:6:"string";}s:10:"gSecretKey";a:2:{s:5:"value";s:40:"6LfZjAYTAAAAAIo0UrNrGfeWxUmoKuQnYajPnm70";s:4:"type";s:6:"string";}s:8:"siteNama";a:2:{s:5:"value";s:10:"Nama Situs";s:4:"type";s:6:"string";}s:11:"siteTagline";a:2:{s:5:"value";s:21:"Tagline singkat situs";s:4:"type";s:6:"string";}s:8:"siteTelp";a:2:{s:5:"value";s:10:"0231123456";s:4:"type";s:6:"string";}s:6:"siteWa";a:2:{s:5:"value";s:10:"0812345678";s:4:"type";s:6:"string";}s:12:"siteTelegram";a:2:{s:5:"value";s:10:"0812345678";s:4:"type";s:6:"string";}s:9:"siteEmail";a:2:{s:5:"value";s:15:"nama@domain.com";s:4:"type";s:6:"string";}s:10:"siteAlamat";a:2:{s:5:"value";s:24:"Kota Cirebon, Jawa Barat";s:4:"type";s:6:"string";}s:11:"logoIkon180";a:2:{s:5:"value";s:16:"crb-icon-180.png";s:4:"type";s:6:"string";}s:11:"logoIkon192";a:2:{s:5:"value";s:16:"crb-icon-192.png";s:4:"type";s:6:"string";}s:10:"logoIkon32";a:2:{s:5:"value";s:15:"crb-icon-32.png";s:4:"type";s:6:"string";}s:8:"logoIkon";a:2:{s:5:"value";s:12:"crb-icon.ico";s:4:"type";s:6:"string";}s:9:"logoWarna";a:2:{s:5:"value";s:18:"crb-logo-warna.png";s:4:"type";s:6:"string";}s:9:"logoPutih";a:2:{s:5:"value";s:18:"crb-logo-putih.png";s:4:"type";s:6:"string";}s:9:"smtpEmail";a:2:{s:5:"value";s:18:"noreply@domain.com";s:4:"type";s:6:"string";}s:8:"smtpNama";a:2:{s:5:"value";s:14:"Noreply Domain";s:4:"type";s:6:"string";}s:12:"smtpPenerima";a:2:{s:5:"value";s:15:"nama@domain.com";s:4:"type";s:6:"string";}s:12:"smtpProtocol";a:2:{s:5:"value";s:4:"smtp";s:4:"type";s:6:"string";}s:8:"smtpHost";a:2:{s:5:"value";s:15:"smtp.domain.com";s:4:"type";s:6:"string";}s:8:"smtpPort";a:2:{s:5:"value";s:2:"25";s:4:"type";s:7:"integer";}s:8:"smtpUser";a:2:{s:5:"value";s:18:"noreply@domain.com";s:4:"type";s:6:"string";}s:8:"smtpPass";a:2:{s:5:"value";s:120:"0yDqqa0Ua2AvopKrMTToZnNrCUJLnR7BrqhFqDih70+aPAGx+AauMvXMDZ/pZcrv366un4LFpXwfQCFjAjaJOWxMfBhF5n5rW/khzlncgEOtxWIpf/mwRogf";s:4:"type";s:6:"string";}s:10:"smtpCrypto";a:2:{s:5:"value";s:3:"tls";s:4:"type";s:6:"string";}s:8:"facebook";a:2:{s:5:"value";s:25:"https://facebook.com/akun";s:4:"type";s:6:"string";}s:9:"instagram";a:2:{s:5:"value";s:26:"https://instagram.com/akun";s:4:"type";s:6:"string";}s:6:"tiktok";a:2:{s:5:"value";s:23:"https://tiktok.com/akun";s:4:"type";s:6:"string";}s:7:"youtube";a:2:{s:5:"value";s:24:"https://youtube.com/akun";s:4:"type";s:6:"string";}}}}';
        // $parsed = unserialize($data);
        // dd($parsed);
        // helper('crb_cache');
        // $rebuild = cacheSetting(true);
        // log_message('info', 'Cache setting rebuilt: ' . json_encode($rebuild));
        // setting('App.dummy');
        // service('settings')->set('App.gRecaptcha', false);
        // service('settings')->set('App.siteNama', 'Nama Situs');
        // service('settings')->set('App.tagLine', 'Nama Situs');
        // service('settings')->flush();

        // $users = auth()->getProvider();
        // $user = $users->findById(2);
        // $user = $users->findByCredentials(['email' => 'admin3@mail.com']);
        // $user->ban();
        // $user->unBan();
        // $user->activate();
        // $user->deactivate();
        // $userModel->save($user);

        // $reader = new Reader(WRITEPATH . 'uploads/GeoLite2-City.mmdb');
        // $record = $reader->city('182.10.161.16');
        // $reader->close();

        // dd([
        //     'negara'     => $record->country->name,
        //     'wilayah'    => $record->mostSpecificSubdivision->name,
        //     'distrik'    => $record->city->name,
        //     'zona_waktu' => $record->location->timeZone,
        //     'lat'        => $record->location->latitude,
        //     'lon'        => $record->location->longitude
        // ]);


        // $settingModel = model(\App\Models\Setting\SettingModel::class);
        // $data = $settingModel->findAll();
        // dd($data);

        // $getUA = $this->request->getUserAgent();
        // $perangkat = $getUA->isMobile() ? 'Mobile' : 'Dekstop';
        // $bit = null;
        // if (stripos($getUA, 'x64') !== false || stripos($getUA, 'win64') !== false || stripos($getUA, 'amd64') !== false) {
        //     $bit = '64-bit';
        // } elseif (stripos($getUA, 'x86') !== false || stripos($getUA, 'i686') !== false) {
        //     $bit = '32-bit';
        // }

        // $info = [
        //     'agent_string' => $getUA->getAgentString(), // UA mentah
        //     'browser' => $getUA->getBrowser() . ' ' . $getUA->getVersion(),
        //     'perangkat' => $perangkat,
        //     'os' => $getUA->getPlatform() . ' ' . $bit,
        //     'brand' => $getUA->getMobile(),
        //     'model'
        // ];

        // $id = session_name() . '.' . session_id();
        // $model = new \App\Models\Auth\SessionsModel();
        // // $info = $model->orderBy('timestamp', 'DESC')->first();
        // $info = $model->where('id', $id)->first();
        // // log_message('debug', 'Last session ID in DB: ' . $info->id);

        // dd($info);

        // helper('crb_device, crb_geoip');

        // $ua     = service('request')->getUserAgent();
        // $device = getDeviceData();
        // $geo    = getGeoIpData();
        // $model = new \App\Models\Auth\SessionsModel();

        // $id = session_name() . ':' . session_id();

        // $model->where('id', $id)->set([
        //     'id_user'   => auth()->id() ?? null,
        //     'perangkat' => $device['device'] ?? null,
        //     'os'        => $ua->getPlatform() ?? null,
        //     'browser'   => $ua->getBrowser() ?? null,
        //     'negara'    => $geo['negara'] ?? null,
        //     'wilayah'   => $geo['wilayah'] ?? null,
        //     'distrik'   => $geo['distrik'] ?? null
        // ])->update();


        // $ch = curl_init("https://get.geojs.io/v1/ip/geo/180.251.224.0.json");
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // $response = curl_exec($ch);
        // curl_close($ch);

        // $data = json_decode($response, true);
        // print_r($data);


        // $geo = file_get_contents("https://get.geojs.io/v1/ip/geo.json");
        // var_dump($geo);

        // return view('Shield/magic_link_message');
        return view('email/standar');
    }

    public function cace()
    {
        $cachePath = WRITEPATH . 'cache/';
        $files = glob($cachePath . '*');
        $list = [];

        foreach ($files as $file) {
            if (is_file($file)) {
                $raw = file_get_contents($file);
                $data = @unserialize($raw);

                if (is_array($data) && isset($data['time'], $data['ttl'])) {
                    $timeCreated = date('Y-m-d H:i:s', $data['time']);
                    $ttl = $data['ttl'];

                    if ($ttl === 0) {
                        $timeExpire = 'lifetime';
                    } else {
                        $timeExpire = date('Y-m-d H:i:s', $data['time'] + $ttl);
                    }

                    $list[] = [
                        'name'        => basename($file),
                        'created'     => $timeCreated,
                        'expires'     => $timeExpire,
                        'ttl'         => $ttl
                    ];
                }
            }
        }

        $info = [
            'pageTitle' => 'User List',
            'navigasi' => '',
            'url' => 'user-list',
            'list' => $list
        ];
        return view('cache_inspector', $info);
    }
}
