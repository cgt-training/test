<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "department".
 *
 * @property integer $department_id
 * @property integer $company_fk_id
 * @property integer $branch_fk_id
 * @property string $department_name
 * @property string $department_create
 * @property string $department_status
 *
 * @property Company $companyFk
 * @property Branch $branchFk
 */
class Department extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'department';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_fk_id', 'branch_fk_id', 'department_name', 'department_create', 'department_status'], 'required'],
            [['company_fk_id', 'branch_fk_id'], 'integer'],
            [['department_create'], 'safe'],
            [['department_status'], 'string'],
            [['department_name'], 'string', 'max' => 255],
            [['company_fk_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_fk_id' => 'company_id']],
            [['branch_fk_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['branch_fk_id' => 'branch_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'department_id' => 'Department ID',
            'company_fk_id' => 'Company Fk ID',
            'branch_fk_id' => 'Branch Fk ID',
            'department_name' => 'Department Name',
            'department_create' => 'Department Create',
            'department_status' => 'Department Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyFk()
    {
        return $this->hasOne(Company::className(), ['company_id' => 'company_fk_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranchFk()
    {
        return $this->hasOne(Branch::className(), ['branch_id' => 'branch_fk_id']);
    }
}
