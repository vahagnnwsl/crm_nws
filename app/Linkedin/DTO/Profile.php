<?php
namespace App\Linkedin\DTO;

class  Profile extends AbstractDTO {

    /**
     * @inheritDoc
     */
    public function fields(): array
    {
        return [
            'fullName',
            'entityUrn',
            'publicIdentifier',
            'headline',
            'secondaryTitle',
            'picture',
            'trackingId'
        ];
    }

    /**
     * @inheritDoc
     */
    public function defaults(): array
    {
        return [

        ];
    }
}
