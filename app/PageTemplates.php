<?php

namespace App;

trait PageTemplates
{
    /*
    |--------------------------------------------------------------------------
    | Page Templates for Backpack\PageManager
    |--------------------------------------------------------------------------
    |
    | Each page template has its own method, that define what fields should show up using the Backpack\CRUD API.
    | Use snake_case for naming and PageManager will make sure it looks pretty in the create/update form
    | template dropdown.
    |
    | Any fields defined here will show up after the standard page fields:
    | - select template
    | - page name (only seen by admins)
    | - page title
    | - page slug
    */


    private function simple_page()
    {
        // Контент английский
        $this->crud->addField([
            'name' => 'content',
            'label' => 'Content',
            'type' => 'wysiwyg',
            'placeholder' => 'Your content here',
            'tab' => 'Eng',
        ]);
        $this->crud->addField([
            'name' => 'meta_title',
            'label' => 'Meta Title',
            'store_in' => 'extras',
            'fake' => true,
            'type' => 'text',
            'tab'   => 'Eng',
        ]);

        $this->crud->addField([
            'name' => 'meta_description',
            'label' => 'Meta Description',
            'store_in' => 'extras',
            'fake' => true,
            'type' => 'text',
            'tab'   => 'Eng',
        ]);

        // Контент русский
        $this->crud->addField([
            'name' => 'title_rus',
            'label' => 'Заголовок',
            'type' => 'text',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Rus',
        ]);
        $this->crud->addField([
            'name' => 'content_rus',
            'label' => 'Контент',
            'type' => 'wysiwyg',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Rus',
        ]);
        $this->crud->addField([
            'name' => 'meta_title_ru',
            'label' => 'Meta Title',
            'store_in' => 'extras',
            'fake' => true,
            'type' => 'text',
            'tab'   => 'Rus',
        ]);

        $this->crud->addField([
            'name' => 'meta_description_ru',
            'label' => 'Meta Description RU',
            'store_in' => 'extras',
            'fake' => true,
            'type' => 'text',
            'tab'   => 'Rus',
        ]);
    }


    private function contacts_page()
    {
        // Контент английский
        $this->crud->addField([
            'name' => 'content',
            'label' => 'Content',
            'type' => 'wysiwyg',
            'placeholder' => 'Your content here',
            'tab' => 'Eng',
        ]);

        // Контент русский
        $this->crud->addField([
            'name' => 'title_rus',
            'label' => 'Заголовок',
            'type' => 'text',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Rus',
        ]);
        $this->crud->addField([
            'name' => 'content_rus',
            'label' => 'Контент',
            'type' => 'wysiwyg',
            'placeholder' => 'Ваш контент здесь',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Rus',
        ]);

        // Контакты
        $this->crud->addField([
            'name' => 'phones',
            'label' => 'Telephone contacts',
            'type' => 'table',
            'entity_singular' => 'option', // used on the "Add X" button
            'columns' => [
                'country' => 'Country',
                'country_ru' => 'Страна',
                'phone' => 'Phone'
            ],
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Contacts',
        ]);
        $this->crud->addField([
            'name' => 'email',
            'label' => 'E-mail',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Contacts',
        ]);
        $this->crud->addField([
            'name' => 'facebook',
            'label' => 'Facebook',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Contacts',
        ]);
        $this->crud->addField([
            'name' => 'instagram',
            'label' => 'Instagram',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Contacts',
        ]);
        $this->crud->addField([
            'name' => 'twitter',
            'label' => 'Twitter',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Contacts',
        ]);

        // Мета данные
    }


    private function footer()
    {
        $this->crud->addField([
            'name' => 'phones',
            'label' => 'Telephone contacts',
            'type' => 'table',
            'entity_singular' => 'option', // used on the "Add X" button
            'columns' => [
                'country' => 'Country',
                'country_ru' => 'Страна',
                'phone' => 'Phone'
            ],
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Contacts',
        ]);
        $this->crud->addField([
            'name' => 'email',
            'label' => 'E-mail',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Contacts',
        ]);
        $this->crud->addField([
            'name' => 'facebook',
            'label' => 'Facebook',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Contacts',
        ]);
        $this->crud->addField([
            'name' => 'instagram',
            'label' => 'Instagram',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Contacts',
        ]);
        $this->crud->addField([
            'name' => 'twitter',
            'label' => 'Twitter',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Contacts',
        ]);
    }


}
