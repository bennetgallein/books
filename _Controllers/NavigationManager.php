<?php
/**
 * Created by PhpStorm.
 * User: bennet
 * Date: 24.10.18
 * Time: 12:53
 */

namespace Controllers;


use Objects\NavPoint;

class NavigationManager {
    /** @var array NavPoint[] */
    private $points = array();

    public function __construct() {
        Panel::setNavManager($this);
    }

    public function addPoint(NavPoint $point) {
        $this->points[] = $point;
    }


    public function pushPoint(NavPoint $point, int $index) {
        $point->setOrderid($index);
        $this->points[$index] = $point;
    }

    public function getBySaveName(string $needle) {
        foreach ($this->points as $point) {
            if ($point->getSaveName() == $needle) {
                return $point;
            }
        }
    }

    public function hasPoint($point) {
        foreach ($this->points as $poin) {
            if ($poin->getSaveName() == $point) {
                return true;
            }
        }
        return false;
    }

    public function __destruct() {
        foreach ($this->points as $point) {
            $point->save();
        }
    }
    public function getHTML() {
        usort($this->points, function($a, $b) {
            return $a->getOrderid() <=> $b->getOrderid();
        });

        $html = "<ul id='test'>";
        foreach ($this->points as $point) {
            $html .= "<li data-id='" . $point->getSaveName() . "'><a href='" . $point->getUrl() . "'>" . $point->getText() . "</a></li>";
        }
        $html .= "</ul>";
        return $html;
    }
}