<?php

/**
 * This is the model class for table "tbl_showcreator".
 *
 * The followings are the available columns in table 'tbl_showcreator':
 * @property integer $id
 * @property integer $showID
 * @property integer $roleID
 * @property integer $individualID
 *
 * The followings are the available model relations:
 * @property Individual $individual
 * @property Role $role
 * @property Show $show
 */
class Showcreator extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_showcreator';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('showID, roleID, individualID', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, showID, roleID, individualID', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'individual' => array(self::BELONGS_TO, 'Individual', 'individualID'),
			'role' => array(self::BELONGS_TO, 'Role', 'roleID'),
			'show' => array(self::BELONGS_TO, 'Show', 'showID'),
		);
	}

	/**
	 * @return array behavior rules.
	 */
	public function behaviors()
    {
		if(Yii::app()->name=='Theatre Profile')
		{
			return array(
				'AuditFieldBehavior' => array(
					// Path to AuditFieldBehavior class.
					'class' => 'audit.components.AuditFieldBehavior',
	 
					// Set to false if you just want to use getDbAttribute and other methods in this class.
					// If left unset the value will come from AuditModule::enableAuditField
					'enableAuditField' => null,
	 
					// Any additional models you want to use to write model and model_id audits to.  If this array is not empty then
					// each field modifed will result in an AuditField being created for each additionalAuditModels.
					'additionalAuditModels' => array(
						//'Post' => 'post_id',
					),
	 
					// A list of values that will be treated as if they were null.
					//'ignoreValues' => array('0', '0.0', '0.00', '0.000', '0.0000', '0.00000', '0.000000', '0000-00-00', '0000-00-00 00:00:00'),
				),
			);
		}
		else
		{
			return array();
		}
    }
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'showID' => 'Show',
			'roleID' => 'Role',
			'individualID' => 'Individual',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('showID',$this->showID);
		$criteria->compare('roleID',$this->roleID);
		$criteria->compare('individualID',$this->individualID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Showcreator the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
