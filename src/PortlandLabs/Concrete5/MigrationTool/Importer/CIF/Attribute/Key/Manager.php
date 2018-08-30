<?php
namespace PortlandLabs\Concrete5\MigrationTool\Importer\CIF\Attribute\Key;

defined('C5_EXECUTE') or die("Access Denied.");

class Manager extends \Concrete\Core\Support\Manager
{
    public function driver($driver = null)
    {
        // If a custom driver is not registered, we use unmapped
        if (!isset($this->customCreators[$driver])) {
            return new UnknownImporter();
        }

        return parent::driver($driver);
    }

    public function __construct($app)
    {
        parent::__construct($app);
        $this->extend('boolean', function () {
            return new BooleanImporter();
        });
        $this->extend('select', function () {
            return new SelectImporter();
        });
        $this->extend('text', function () {
            return new TextImporter();
        });
        $this->extend('textarea', function () {
            return new TextAreaImporter();
        });
        $this->extend('image_file', function () {
            return new ImageFileImporter();
        });
        $this->extend('topics', function () {
            return new TopicsImporter();
        });
        $this->extend('rating', function () {
            return new RatingImporter();
        });
        $this->extend('number', function () {
            return new NumberImporter();
        });
        $this->extend('social_links', function () {
            return new SocialLinksImporter();
        });
        $this->extend('date_time', function () {
            return new DateTimeImporter();
        });
        $this->extend('address', function () {
            return new AddressImporter();
        });

        $this->extend('url', function () {
            return new TextImporter();
        });


        // No, these are not core attributes, but they will be soon, and we need to know
        // how to deal with their fields on import so we're going to add them to the migration tool

        $this->extend('page', function () {
            return new PageImporter();
        });
        $this->extend('page_selector', function () {
            return new PageImporter();
        });

    }
}
