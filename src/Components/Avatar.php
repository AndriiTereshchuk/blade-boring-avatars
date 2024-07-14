<?php
namespace ATereshchuk\BladeBoringAvatars\Components;

use Illuminate\View\Component;
use ATereshchuk\BladeBoringAvatars\Helper;

class Avatar extends Component
{
    public $colors;
    public $size;
    public $name;

    protected $numberFromName;

    public $avatarData = [];

    public function __construct(int $size = 40, string $name = "John Doe", ?array $colors = null)
    {
        $this->size = $size;
        $this->name = $name;
        $this->colors = $colors ?? [
            '#92A1C6',
            '#146A7C',
            '#F0AB3D',
            '#C271B4',
            '#C20D90'
        ];
    }

    public function render()
    {
        $this->generateData();

        return view('blade-boring-avatars::avatar');
    }

    public function generateData()
    {
        $this->numberFromName = Helper::getNumber($this->name);

        $this->avatarData['wrapperColor'] = Helper::getRandomElement($this->numberFromName, $this->colors);
        $this->avatarData['backgroundColor'] = Helper::getRandomElement($this->numberFromName + 13, $this->colors);
        $this->avatarData['faceColor'] = Helper::getContrast($this->avatarData['wrapperColor']);

        $this->avatarData['isCircle'] = Helper::getBoolean($this->numberFromName, 1);
        $this->avatarData['isMouthOpen'] = Helper::getBoolean($this->numberFromName, 2);

        $this->avatarData['preTranslateX'] = Helper::getUnit($this->numberFromName, 10, 1);
        $this->avatarData['wrapperTranslateX'] = ($this->avatarData['preTranslateX'] < 5) ? $this->avatarData['preTranslateX'] + 4 : $this->avatarData['preTranslateX'];
        $this->avatarData['preTranslateY'] = Helper::getUnit($this->numberFromName, 10, 2);
        $this->avatarData['wrapperTranslateY'] = ($this->avatarData['preTranslateY'] < 5) ? $this->avatarData['preTranslateY'] + 4 : $this->avatarData['preTranslateY'];
        $this->avatarData['wrapperRotate'] = Helper::getUnit($this->numberFromName, 360);
        $this->avatarData['wrapperScale'] = 1 + (Helper::getUnit($this->numberFromName, 3) / 10);
        $this->avatarData['eyeSpread'] = Helper::getUnit($this->numberFromName, 5);
        $this->avatarData['mouthSpread'] = Helper::getUnit($this->numberFromName, 3);
        $this->avatarData['faceRotate'] = Helper::getUnit($this->numberFromName, 10, 3);
        $this->avatarData['faceTranslateX'] = ($this->avatarData['wrapperTranslateX'] > $this->size/6) ? $this->avatarData['wrapperTranslateX'] / 2 : Helper::getUnit($this->numberFromName, 8, 1);
        $this->avatarData['faceTranslateY'] = ($this->avatarData['wrapperTranslateY'] > $this->size/6) ? $this->avatarData['wrapperTranslateY'] / 2 : Helper::getUnit($this->numberFromName, 7, 2);
    }
}
