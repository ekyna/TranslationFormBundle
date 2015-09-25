<?php

namespace A2lix\TranslationFormBundle\Form\EventListener;

use Doctrine\Common\Collections\Collection,
    Symfony\Component\Form\FormEvent,
    Symfony\Component\Form\FormEvents,
    Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @author David ALLIX
 */
class TranslationsFormsListener implements EventSubscriberInterface
{
    /**
     *
     * @param \Symfony\Component\Form\FormEvent $event
     */
    public function submit(FormEvent $event)
    {
        $data = $event->getData();

        foreach ($data as $locale => $translation) {
            // Remove useless Translation object
            if (!$translation) {
                if ($data instanceof Collection) {
                    $data->removeElement($translation);
                } else {
                    unset($data[$locale]);
                }
            } else {
                $translation->setLocale($locale);
            }
        }

        $event->setData($data);
    }

    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::SUBMIT => 'submit',
        );
    }
}
