<?php

namespace Database\Seeders;

use App\Models\Navbar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NavBarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Navbar::truncate();

        foreach ($this->data() as $role => $arrays)
        {
            foreach ($arrays as $data)
            {
                $navbar = Navbar::create([
                    'title' => $data['title'],
                    'icon' => $data['icon'],
                    'ordering' =>  $data['ordering']??0,
                    'route' => $data['route']??'',
                ]);

                $navbar->assignRole($role);

                if(isset($data['childrens']))
                {
                    foreach ($data['childrens'] as $children)
                    {
                        $child = Navbar::create([
                            'title' => $children['title'],
                            'ordering' =>  $children['ordering']??0,
                            'parent_id' => $navbar->id,
                            'route' => $children['route']??'',
                        ]);
                        $child->assignRole($role);
                    }
                }
            }
        }

    }

    public function data(): array
    {
        return array(
            'of' => array(
                array(
                    'title'=>array('fr'=>'Synthèse','en'=>''),
                    'icon' => '<i class="far fa-house fa-lg"></i>',
                    'ordering' => 0,
                    'route' => 'of.index'
                ),
                array(
                    'title'=>array('fr'=>'Profil','en'=>''),
                    'icon' => '<i class="far fa-user-circle fa-lg"></i>',
                    'ordering' => 1,

                    'childrens' => array(
                        array(
                            'title'=>array('fr'=>'Profil OF','en'=>''),
                            'icon' => '<i class="far fa-house fa-lg"></i>',
                            'ordering' => 0,
                            'route' => 'of.profile.edit'
                        ),
                        array(
                            'title'=>array('fr'=>'Administrateurs','en'=>''),
                            'icon' => '<i class="far fa-house fa-lg"></i>',
                            'ordering' => 1,
                            'route' => 'of.users.index'
                        ),
                        array(
                            'title'=>array('fr'=>'Abonnement','en'=>''),
                            'icon' => '<i class="far fa-house fa-lg"></i>',
                            'ordering' => 2
                        ),
                    )
                ),
                array(
                    'title'=>array('fr'=>'Formations','en'=>''),
                    'icon' => '<i class="far fa-graduation-cap fa-lg"></i>',
                    'ordering' => 2,
                    'route' => 'of.courses.index'
                ),
                array(
                    'title'=>array('fr'=>'Formateurs','en'=>''),
                    'icon' => '<i class="far fa-person-chalkboard fa-lg"></i>',
                    'ordering' => 3,
                    'route' => 'of.trainers.index'
                ),
                array(
                    'title'=>array('fr'=>'Salles','en'=>''),
                    'icon' => '<i class="far fa-location-dot fa-lg"></i>',
                    'ordering' => 4,
                    'parent_id' => null,
                    'route' => 'of.classrooms.index'
                ),
                array(
                    'title'=>array('fr'=>'Sessions','en'=>''),
                    'icon' => '<i class="far fa-table-cells-large fa-lg"></i>',
                    'ordering' => 5,
                    'parent_id' => null,
                    'route' => 'of.sessions.index'
                ),
                array(
                    'title'=>array('fr'=>'Suivi','en'=>''),
                    'icon' => '<i class="far fa-chart-simple fa-lg"></i>',
                    'ordering' => 6,
                    'childrens' => array(
                        array(
                            'title'=>array('fr'=>'Suivi sessions','en'=>''),
                            'ordering' => 0,
                            'route' => 'of.monitoring.sessions'
                        ),
                        array(
                            'title'=>array('fr'=>'Suivi e-learning','en'=>''),
                            'ordering' => 1,
                            'route' => 'of.monitoring.elearnings'
                        ),
                        array(
                            'title'=>array('fr'=>'Suivi clients','en'=>''),
                            'ordering' => 2,
                            'route' => 'of.monitoring.customers'
                        ),
                        array(
                            'title'=>array('fr'=>'Récapitulatif financier','en'=>''),
                            'ordering' => 3
                        ),
                        array(
                            'title'=>array('fr'=>'Demandes d\'information','en'=>''),
                            'ordering' => 4
                        ),
                    )
                ),
                array(
                    'title'=>array('fr'=>'Codes promo','en'=>''),
                    'icon' => '<i class="far fa-percent fa-lg"></i>',
                    'ordering' => 7,
                    'parent_id' => null,
                    'route' => 'of.promotions.index'
                ),
            ),
            'group' => array(
                array(
                    'title'=>array('fr'=>'Profil','en'=>''),
                    'icon' => '<i class="far fa-user-circle fa-lg"></i>',
                    'ordering' => 0,
                    'childrens' => array(
                        array(
                            'title'=>array('fr'=>'Profil Groupe','en'=>''),
                            'icon' => '<i class="far fa-house fa-lg"></i>',
                            'ordering' => 0,
                        ),
                        array(
                            'title'=>array('fr'=>'Administrateurs','en'=>''),
                            'icon' => '<i class="far fa-house fa-lg"></i>',
                            'ordering' => 1,
                        ),
                        array(
                            'title'=>array('fr'=>'Abonnement','en'=>''),
                            'icon' => '<i class="far fa-house fa-lg"></i>',
                            'ordering' => 2
                        ),
                    )
                ),
                array(
                    'title'=>array('fr'=>'Sociétés','en'=>''),
                    'icon' => '<i class="far fa-graduation-cap fa-lg"></i>',
                    'ordering' => 1,

                ),
                array(
                    'title'=>array('fr'=>'Documents','en'=>''),
                    'icon' => '<i class="far fa-folder-open fa-lg"></i>',
                    'ordering' => 2,
                ),
                array(
                    'title'=>array('fr'=>'Exports','en'=>''),
                    'icon' => '<i class="far fa-file-export fa-lg"></i>',
                    'ordering' => 3,
                )
            ),
            'company' => array(
                array(
                    'title'=>array('fr'=>'Synthèse','en'=>''),
                    'icon' => '<i class="far fa-house fa-lg"></i>',
                    'ordering' => 0,
                    'route' => 'company.index'
                ),
                array(
                    'title'=>array('fr'=>'Profil','en'=>''),
                    'icon' => '<i class="far fa-user-circle fa-lg"></i>',
                    'ordering' => 1,
                    'childrens' => array(
                        array(
                            'title'=>array('fr'=>'Profil Société','en'=>''),
                            'icon' => '<i class="far fa-house fa-lg"></i>',
                            'ordering' => 0,
                            'route' => 'company.profile.edit'
                        ),
                        array(
                            'title'=>array('fr'=>'Administrateurs','en'=>''),
                            'icon' => '<i class="far fa-house fa-lg"></i>',
                            'ordering' => 1,
                            'route' => 'company.users.index'
                        ),
                        array(
                            'title'=>array('fr'=>'Abonnement','en'=>''),
                            'icon' => '<i class="far fa-house fa-lg"></i>',
                            'ordering' => 2,
                            //'route' => 'company.subscription.index'
                        ),
                    )
                ),
                array(
                    'title'=>array('fr'=>'Profil suivi','en'=>''),
                    'icon' => '<i class="far fa-chart-simple fa-lg"></i>',
                    'ordering' => 2,
                    'route' => 'company.monitoring.index'

                ),
                array(
                    'title'=>array('fr'=>'Inscriptions','en'=>''),
                    'icon' => '<i class="far fa-pen fa-lg"></i>',
                    'ordering' => 3,
                    //'route' => 'front.courses.index'
                ),
                array(
                    'title'=>array('fr'=>'Apprenants','en'=>'Learners'),
                    'icon' => '<i class="far fa-graduation-cap fa-lg"></i>',
                    'ordering' => 4,
                    'route' => 'company.learners.index'
                ),
                array(
                    'title'=>array('fr'=>'Documents','en'=>''),
                    'icon' => '<i class="far fa-folder-open fa-lg"></i>',
                    'ordering' => 5,
                    //'route' => 'company.documents.index'
                )
            ),
            'learner' => array(
                array(
                    'title'=>array('fr'=>'Suivi','en'=>''),
                    'icon' => '<i class="far fa-house fa-lg"></i>',
                    'ordering' => 0,
                    //'route' => 'learner.enrollments.index'
                ),
                array(
                    'title'=>array('fr'=>'Profil','en'=>''),
                    'icon' => '<i class="far fa-user-circle fa-lg"></i>',
                    'ordering' => 1,
                   // 'route' => 'learner.profile'
                ),
                array(
                    'title'=>array('fr'=>'Inscriptions','en'=>''),
                    'icon' => '<i class="far fa-pen fa-lg"></i>',
                    'ordering' => 2,
                    //'route' => 'front.courses.index'
                ),
                array(
                    'title'=>array('fr'=>'Documents','en'=>''),
                    'icon' => '<i class="far fa-folder-open fa-lg"></i>',
                    'ordering' => 3,
                   // 'route' => 'company.documents.index'
                )
            ),
            'trainer' => array(
                array(
                    'title'=>array('fr'=>'Suivi sessions','en'=>''),
                    'icon' => '<i class="far fa-chart-simple fa-lg"></i>',
                    'ordering' => 0,
                    'route' => 'trainer.sessions.index'
                ),
                array(
                    'title'=>array('fr'=>'Profil','en'=>''),
                    'icon' => '<i class="far fa-user-circle fa-lg"></i>',
                    'ordering' => 1,
                     'route' => 'trainer.profile.edit'
                )
            ),
        );
    }
}
