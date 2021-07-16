<?php

namespace Modules\Polls\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterPollsSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
            $group->item(trans('polls::polls.title.polls'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                     /* append */
                );
                $item->item(trans('polls::questiontypes.title.questiontypes'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.polls.questiontype.create');
                    $item->route('admin.polls.questiontype.index');
                    $item->authorize(
                        $this->auth->hasAccess('polls.questiontypes.index')
                    );
                });
                $item->item(trans('polls::questions.title.questions'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.polls.question.create');
                    $item->route('admin.polls.question.index');
                    $item->authorize(
                        $this->auth->hasAccess('polls.questions.index')
                    );
                });
                $item->item(trans('polls::answers.title.answers'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.polls.answer.create');
                    $item->route('admin.polls.answer.index');
                    $item->authorize(
                        $this->auth->hasAccess('polls.answers.index')
                    );
                });
// append



            });
        });

        return $menu;
    }
}
