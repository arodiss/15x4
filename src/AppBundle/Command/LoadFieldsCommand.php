<?php

namespace AppBundle\Command;

use AppBundle\Entity\Field;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LoadFieldsCommand extends AbstractCommand
{
    /** @var array */
    protected $config = [
        [
            'name' => 'Математика',
            'image' => 'math.jpg',
            'description' => 'Он стал поэтом. Для математики у него было слишком мало воображения - Давид Гильберт об одном из своих бывших учеников',
        ],

        [
            'name' => 'Искусство',
            'image' => 'arts.jpg',
            'description' => 'Религия, Искусство и Наука — это ветви одного и того же дерева. Альберт Эйнштейн',
        ],

        [
            'name' => 'История',
            'description' => 'Закономерность исторических явлений обратно пропорциональна их духовности - Василий Ключевский',
            'image' => 'history.jpg',
        ],

        [
            'name' => 'Наука',
            'description' => 'Наука всегда не права. Она не в состоянии решить ни одного вопроса, не поставив при этом с десяток новых - Бернард Шоу',
            'image' => 'science.jpg',
        ],

        [
            'name' => 'Химия',
            'description' => 'Всё, что в есть химии научного, это физика, а остальное — кухня. Лев Ландау',
            'image' => 'chemistry.jpg',
        ],

        [
            'name' => 'Биология',
            'description' => 'Пресловутое недостающее звено между обезьяной и цивилизованным человеком — это как раз мы. Конрад Лоренц',
            'image' => 'biology.jpg',
        ],

        [
            'name' => 'Физика',
            'description' => 'В среде физиков-теоретиков высоко ценится способность задать глупый вопрос. С него часто начинается открытие новых путей и понятий. Георгий Гачев',
            'image' => 'physics.jpg',
        ],

        [
            'name' => 'Лингвистика',
            'description' => 'Язык имеет большое значение еще и потому, что с его помощью мы можем прятать наши мысли - Вольтер',
            'image' => 'linguistics.jpg',
        ],

        [
            'name' => 'Компьютеры',
            'description' => 'Лучший способ в чём-то разобраться до конца — это попробовать научить этому компьютер. Дональд Кнут',
            'image' => 'computers.jpg',
        ],


        [
            'name' => 'Лекции',
            'description' => 'Красноречие - это живописное изображение мысли. Блез Паскаль',
            'image' => 'lectures.jpg',
        ],

        [
            'name' => 'Космос',
            'description' => 'Иногда я чувствую себя более причастным к галактике M33, чем к тому, что лежит у меня на тарелке - Борис Кригер',
            'image' => 'space.jpg',
        ],

        [
            'name' => 'Психология',
            'description' => 'Сон разума порождает чудовищ — Франсиско Гойя',
            'image' => 'psycho.jpg',
        ],

        [
            'name' => 'Социология',
            'description' => 'Достаточно взглянуть на историю человечества, как станет понятно, что интеллект любого государства, его осмысленное поведение находится на уровне пятилетнего ребенка - Ленонид Каганов',
            'image' => 'socio.jpg',
        ],

        [
            'name' => 'Экономика',
            'description' => 'Экономика должна быть экономной — Леонид Брежнев',
            'image' => 'economics.jpg',
        ],

        [
            'name' => 'Медицина',
            'description' => 'Прежде магию путали с медициной; ныне медицину путают с магией — Томас Сас',
            'image' => 'medical.jpg',
        ],

        [
            'name' => 'Общество',
            'description' => 'Общество — это коромысло весов, которое не может приподнимать одних, не понижая других — Жак Ваньер',
            'image' => 'society.jpg',
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
}
