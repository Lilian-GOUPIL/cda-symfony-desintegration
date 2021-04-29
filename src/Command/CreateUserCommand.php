<?php

namespace App\Command;

use App\Entity\User;
use App\Service\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateUserCommand extends Command
{
    private $userService;

    protected static $defaultName = 'app:create-user';
    protected static $defaultDescription = 'Creates a new user account';

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription(self::$defaultDescription)
            ->setHelp('This command allows you to create a new user account');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        $username = $io->ask('What is the user\'s username ?');
        $roles = [];
        $firstName = $io->ask('What is the user\'s first name ?');
        $lastName = $io->ask('What is the user\'s last name ?');

        if ($io->confirm('Is the user administrator ?', false)) {
            $roles[] = 'ROLE_ADMIN';
            
            if ($io->confirm('Is the user super administrator ?', false)) {
                $roles[] = 'ROLE_SUPER_ADMIN';
            }
        }

        $user = new User();
        $user->setUsername(strtolower($username))
            ->setRoles($roles)
            ->setFirstName($firstName)
            ->setLastName($lastName);

        $this->userService->new($user);

        $io->success('The user was successfully created !');


        return Command::SUCCESS;
    }
}
