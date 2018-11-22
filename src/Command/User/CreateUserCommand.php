<?php declare(strict_types=1);

namespace BalticRobo\Api\Command\User;

use BalticRobo\Api\Entity\User\Email;
use BalticRobo\Api\Entity\User\Roles;
use BalticRobo\Api\Model\User\UserDTO;
use BalticRobo\Api\Service\User\ManageUserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

final class CreateUserCommand extends Command
{
    private $userService;
    private $helper;
    private $forename;
    private $surname;
    private $email;
    private $password;
    private $admin;
    private $active;

    public function __construct(ManageUserService $manageUserService)
    {
        $this->userService = $manageUserService;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('balticrobo:user:create')
            ->setDescription('Creates a new user.')
            ->setHelp('This command allows you to create a user.');
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->helper = $this->getHelper('question');
        $output->writeln(['BalticRobo User Creator', '=======================']);
    }

    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        $this->email = new Email($this->helper->ask($input, $output, $this->question('Email')));
        $this->forename = $this->helper->ask($input, $output, $this->question('Forename'));
        $this->surname = $this->helper->ask($input, $output, $this->question('Surname'));
        $this->password = $this->helper->ask($input, $output, $this->question('Password', true));
        $this->admin = $this->helper->ask($input, $output, $this->confirmation('Is administrator?'));
        $this->active = $this->helper->ask($input, $output, $this->confirmation('Is active?'));
        $question = "Are you sure to create user: {$this->forename} {$this->surname} ({$this->email->getAddress()})?";
        if (!$this->helper->ask($input, $output, $this->confirmation($question, true))) {
            return;
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $now = new \DateTimeImmutable();
        $user = new UserDTO($this->forename, $this->surname, $this->email, $this->getRoles($this->admin));
        $user->setPlainPassword($this->password);
        $user->setActive($this->active);
        $this->userService->create($user, $now);
        $output->writeln(['=======================', "New user created at {$now->format('Y-m-d H:i')}."]);
    }

    private function question(string $field, bool $hidden = false): Question
    {
        $question = new Question("{$field}: ");
        $question->setHidden($hidden);
        $question->setValidator(function ($value) use ($field) {
            return $this->questionValidation($value, $field);
        });
        $question->setMaxAttempts(4);

        return $question;
    }

    private function questionValidation(?string $value, string $field): string
    {
        if (!$value || '' === trim($value)) {
            throw new \Exception("{$field} cannot be empty.");
        }
        if ('Email' === $field && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception("{$field} is incorrect.");
        }

        return $value;
    }

    private function confirmation(string $question, bool $default = false): ConfirmationQuestion
    {
        $defaults = "y/N";
        if ($default) {
            $defaults = "Y/n";
        }

        return new ConfirmationQuestion("{$question} ({$defaults}): ", $default);
    }

    private function getRoles(bool $isAdmin): Roles
    {
        $roles = ['ROLE_USER'];
        if ($isAdmin) {
            $roles[] = 'ROLE_ADMIN';
        }

        return new Roles($roles);
    }
}
