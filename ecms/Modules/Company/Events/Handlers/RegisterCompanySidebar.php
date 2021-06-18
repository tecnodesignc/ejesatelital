<?php

namespace Modules\Company\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterCompanySidebar implements \Maatwebsite\Sidebar\SidebarExtender
{
    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    public function handle(BuildingSidebar $sidebar)
    {
        $sidebar->add($this->extendWith($sidebar->getMenu()));
    }

    /**
     * @param Menu $menu
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('company::companies.title.companies'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                    $this->auth->hasAccess('company.contacts.index') || $this->auth->hasAccess('company.accounts.index') || $this->auth->hasAccess('company.accounttypes.index')
                );
                $item->item(trans('company::accounts.title.accounts'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.company.account.create');
                    $item->route('admin.company.account.index');
                    $item->authorize(
                        $this->auth->hasAccess('company.accounts.index')
                    );
                });
                $item->item(trans('company::contacts.title.contacts'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.company.contact.create');
                    $item->route('admin.company.contact.index');
                    $item->authorize(
                        $this->auth->hasAccess('company.contacts.index')
                    );
                });
                $item->item(trans('company::accounttypes.title.accounttypes'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.company.accounttype.create');
                    $item->route('admin.company.accounttype.index');
                    $item->authorize(
                        $this->auth->hasAccess('company.accounttypes.index')
                    );
                });
// append



            });
        });

        return $menu;
    }
}
