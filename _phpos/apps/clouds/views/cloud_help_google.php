<?php

$form->title(txt('cloud_google_help_title'), '', ICONS.'tip.png');
echo $form->render();
echo $layout->txtdesc(txt('cloud_google_help_step1'));
echo '<img src="'.MY_RESOURCES_URL.'help_cloud_google1.jpg" />';
echo $layout->txtdesc(txt('cloud_google_help_step2'));
echo $layout->txtdesc(txt('cloud_google_help_step3'));
echo '<img src="'.MY_RESOURCES_URL.'help_cloud_google3.jpg" />';
echo $layout->txtdesc(txt('cloud_google_help_step4'));

?>