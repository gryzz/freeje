<?php
require_once PATH_PRESENTATION . 'common/interfaces/IPage.php';
require_once PATH_PRESENTATION . 'ActivatePage/ActivateRequest.php';
require_once PATH_APPLICATION . 'Caller.php';

require_once ROOT . 'propel/runtime/lib/Propel.php';

class ActivatePage implements IPage {

    public function execute() {
        $propel = Propel::init(PATH_PROPEL_CONF);

        $request = new ActivateRequest();
        
        $caller = Caller::getInstance();
        
        $result = $caller->makeActivateUserByCodeCall($request->getFuid(), $request->getKey(), $request->getS2email());

        if (is_array($result)) {
            $user = UserQuery::create()->findOneByFreejeId($request->getFuid());

            $user->setLogin($result['login']);
            $user->setPassword($result['password']);

            $user->save();

            header('Location: ' . WWW_ROOT . '/?section=activate');
        }




    }
}

?>
