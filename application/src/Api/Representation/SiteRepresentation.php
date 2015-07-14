<?php
namespace Omeka\Api\Representation;

use Omeka\Api\Representation\SitePermissionRepresentation;

class SiteRepresentation extends AbstractEntityRepresentation
{
    /**
     * {@inheritDoc}
     */
    public function url($action = null)
    {
        $url = $this->getViewHelper('Url');
        return $url(
            'admin/site/default',
            array(
                'site-slug' => $this->slug(),
                'action' => $action,
            )
        );
    }
    public function getJsonLd()
    {
        $entity = $this->getData();

        $pages = array();
        foreach ($this->pages() as $pageRepresentation) {
            $pages[] = $pageRepresentation->reference();
        }

        return array(
            'o:slug'       => $entity->getSlug(),
            'o:theme'      => $entity->getTheme(),
            'o:title'      => $entity->getTitle(),
            'o:navigation' => $entity->getNavigation(),
            'o:page'       => $pages,
            'o:site_permission' => $this->sitePermissions(),
            'o:owner'      => $this->owner()->reference(),
        );
    }

    public function slug()
    {
        return $this->getData()->getSlug();
    }

    public function title()
    {
        return $this->getData()->getTitle();
    }

    public function theme()
    {
        return $this->getData()->getTheme();
    }

    public function navigation()
    {
        return $this->getData()->getNavigation();
    }

    public function pages()
    {
        $pages = array();
        $pageAdapter = $this->getAdapter('site_pages');
        foreach ($this->getData()->getPages() as $page) {
            $pages[] = $pageAdapter->getRepresentation(null, $page);
        }
        return $pages;
    }

    /**
     * Return the permissions assigned to this site.
     *
     * @return array
     */
    public function sitePermissions()
    {
        $sitePermissions = array();
        foreach ($this->getData()->getSitePermissions() as $sitePermission) {
            $sitePermissions[]= new SitePermissionRepresentation(
                $sitePermission, $this->getServiceLocator());
        }
        return $sitePermissions;
    }

    /**
     * Get the owner representation of this resource.
     *
     * @return UserRepresentation
     */
    public function owner()
    {
        return $this->getAdapter('users')
            ->getRepresentation(null, $this->getData()->getOwner());
    }
}
