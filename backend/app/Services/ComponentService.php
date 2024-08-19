<?php 

    namespace App\Services;

    use App\Models\Component;

    class ComponentService{

        public function createComponent(array $data): Component {
            $component = Component::create($data);
            $component->save();
            return $component;
        }
    }