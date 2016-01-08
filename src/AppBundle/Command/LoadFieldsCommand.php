<?php

namespace AppBundle\Command;

use AppBundle\Entity\Field;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LoadFieldsCommand extends ContainerAwareCommand
{
    /** @var array */
    protected $config = [
        [
            'name' => 'Математика',
            'description' => 'Он стал поэтом. Для математики у него было слишком мало воображения - Давид Гильберт об ожном из своих бывших учеников',
            'image' => '',
        ],

        [
            'name' => 'Искусство',
            'description' => 'Религия, Искусство и Наука — это ветви одного и того же дерева - Альберт Эйнштейн',
            'image' => '',
        ],

        [
            'name' => 'История',
            'description' => 'Закономерность исторических явлений обратно пропорциональна их духовности - Василий Ключевский',
            'image' => '',
        ],

        [
            'name' => 'Наука',
            'description' => 'Наука всегда не права. Она не в состоянии решить ни одного вопроса, не поставив при этом с десяток новых - Бернард Шоу',
            'image' => '',
        ],

        [
            'name' => 'Химия',
            'description' => 'Всё, что в есть химии научного, это физика, а остальное — кухня. Лев Ландау',
            'image' => '',
        ],

        [
            'name' => 'Биология',
            'description' => 'Пресловутое недостающее звено между обезьяной и цивилизованным человеком — это как раз мы. Конрад Лоренц',
            'image' => '',
        ],

        [
            'name' => 'Физика',
            'description' => 'В среде физиков-теоретиков высоко ценится способность задать глупый вопрос. С него часто начинается открытие новых путей и понятий. Георгий Гачев',
            'image' => '',
        ],

        [
            'name' => 'Лингвистика',
            'description' => 'Язык имеет большое значение еще и потому, что с его помощью мы можем прятать наши мысли - Вольтер',
            'image' => '',
        ],

        [
            'name' => 'Компьютеры',
            'description' => 'Лучший способ в чём-то разобраться до конца — это попробовать научить этому компьютер. Дональд Кнут',
            'image' => '',
        ],


        [
            'name' => 'Лекции',
            'description' => 'Красноречие - это живописное изображение мысли. Блез Паскаль',
            'image' => '',
        ],

        [
            'name' => 'Космос',
            'description' => 'Иногда я чувствую себя более причастным к галактике M33, чем к тому, что лежит у меня на тарелке - Борис Кригер',
            'image' => '',
        ],

        [
            'name' => 'Психология',
            'description' => 'Сон разума порождает чудовищ — Франсиско Гойя',
            'image' => '',
        ],

        [
            'name' => 'Социология',
            'description' => 'Достаточно взглянуть на историю человечества, как станет понятно, что интеллект любого государства, его осмысленное поведение находится на уровне пятилетнего ребенка - Ленонид Каганов',
            'image' => '',
        ],

        [
            'name' => 'Экономика',
            'description' => 'Экономика должна быть экономной — Леонид Брежнев',
            'image' => '',
        ],
    ];

    /** {@inheritdoc} */
    protected function configure()
    {
        $this->setName("15x4:load-fields");
    }

    /** {@inheritdoc} */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Loading lecture fields...");

        foreach ($this->config as $fieldConfig) {
            $field = new Field();
            $field->setName($fieldConfig['name']);
            $field->setDescription($fieldConfig['description']);
            $field->setImageName($fieldConfig['image']);
            $this->getEm()->persist($field);
        }
        $this->getEm()->flush();

        $output->writeln("<info>Lecture fields loaded</info> ");
    }

    /** @return EntityManager */
    protected function getEm()
    {
        return $this->getContainer()->get("doctrine.orm.entity_manager");
    }
} 
