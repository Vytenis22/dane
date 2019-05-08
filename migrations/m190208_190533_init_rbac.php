<?php

use yii\db\Migration;
use yii\rbac\DbManager;

/**
 * Class m190208_190533_init_rbac
 */
class m190208_190533_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$auth = Yii::$app->authManager;
        
        // add "createAssist" permission ---- admin
        $createAssist = $auth->createPermission('createAssist');
        $createAssist->description = 'Create visit for assistant';
        $auth->add($createAssist);
        
        // add "manageServices" permission ---- admin
        $manageServices = $auth->createPermission('manageServices');
        $manageServices->description = 'Manage all services';
        $auth->add($manageServices);
        
        // add "manageMaterials" permission ---- admin
        $manageMaterials = $auth->createPermission('manageMaterials');
        $manageMaterials->description = 'Manage all materials';
        $auth->add($manageMaterials);
		
		// add "manageAssignments" permission ---- admin
        $manageAssignments = $auth->createPermission('manageAssignments');
        $manageAssignments->description = 'Manage service assignments';
        $auth->add($manageAssignments);
		
		// add "manageUsers" permission ---- admin
        $manageUsers = $auth->createPermission('manageUsers');
        $manageUsers->description = 'Manage users';
        $auth->add($manageUsers);
        
        // add "createAssist" permission ---- doctor
        $createVisit = $auth->createPermission('createVisit');
        $createVisit->description = 'Create visit';
        $auth->add($createVisit);
		
		// add "manageVisits" permission ---- doctor
        $manageVisits = $auth->createPermission('manageVisits');
        $manageVisits->description = 'manage patients visits';
        $auth->add($manageVisits);
		
		// add "managePlans" permission ---- doctor
        $managePlans = $auth->createPermission('managePlans');
        $managePlans->description = 'Manage patients treatments plans';
        $auth->add($managePlans);
		
		// add "manageRecipes" permission ---- doctor
        $manageRecipes = $auth->createPermission('manageRecipes');
        $manageRecipes->description = 'Manage patients recipes';
        $auth->add($manageRecipes);
		
		// add "managePatients" permission ---- doctor
        $managePatients = $auth->createPermission('managePatients');
        $managePatients->description = 'Manage patients';
        $auth->add($managePatients);

        // add "doctor" role and give this role the "createPost" permission
        $doctor = $auth->createRole('doctor', 'Gydytojas');
        $doctor->description = 'doctors';
        $auth->add($doctor);
        $auth->addChild($doctor, $createVisit);
        $auth->addChild($doctor, $manageVisits);
        $auth->addChild($doctor, $managePlans);
        $auth->addChild($doctor, $manageRecipes);
        $auth->addChild($doctor, $managePatients);

        // add "doctor" role and give this role the "createPost" permission

        $assistant = $auth->createRole('assistant', 'Asistentas');
        $assistant->description = 'assist to doctors';
        $auth->add($assistant);
        $auth->addChild($doctor, $assistant);

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "doctor" role
        $admin = $auth->createRole('admin', 'Administratorius');
        $admin->description = 'system administrator';
        $auth->add($admin);
        $auth->addChild($admin, $doctor);
        $auth->addChild($admin, $createAssist);
        $auth->addChild($admin, $manageServices);
        $auth->addChild($admin, $manageMaterials);
		$auth->addChild($admin, $manageAssignments);
		$auth->addChild($admin, $manageUsers);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.

        //$roleD = $auth->getRole('doctor');
        //$res = $auth->revoke($roleD, 14);
        $auth->assign($assistant, 14);
        $auth->assign($doctor, 13);
        $auth->assign($assistant, 12);
        $auth->assign($doctor, 11);
        $auth->assign($doctor, 10);
        $auth->assign($doctor, 9);
        $auth->assign($doctor, 8);
        $auth->assign($doctor, 7);
        $auth->assign($doctor, 6);
        $auth->assign($doctor, 5);
        $auth->assign($admin, 4);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        //echo "m190208_190533_init_rbac cannot be reverted.\n";
		$auth = Yii::$app->authManager;

        $auth->removeAll();

        //return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190208_190533_init_rbac cannot be reverted.\n";

        return false;
    }
    */
}
