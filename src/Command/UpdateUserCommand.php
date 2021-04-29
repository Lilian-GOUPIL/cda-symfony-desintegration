<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Services\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UpdateUserCommand extends Command
{
    private $userService;
    
    protected static $defaultName = 'app:update-user';
    protected static $defaultDescription = 'Creates an existing user account';

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription(self::$defaultDescription)
            ->setHelp('This command allows you to update an existing user account');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        $username = $io->ask('What is the username of the user to update ?');

        $user = $this->userService->findOneBy(['username' => $username]);

        if ($user !== null) {
            $io->info('Retrieved ' . $user);

            $username = $io->ask('What is the user\'s new username ? (Leave empty to keep old username)');
            $resetPassword = $io->confirm('Do you want to reset the user\'s password ?', false);
            $roles = null;
            $firstName = $io->ask('What is the user\'s new first name ? (Leave empty to keep old first name)');
            $lastName = $io->ask('What is the user\'s new last name ? (Leave empty to keep old last name)');
            
            $updateRoles = $io->confirm('Do you want to update the user\'s role ?', false);

            if ($updateRoles) {
                $roles = [];

                if ($io->confirm('Is the user administrator ?', false)) {
                    $roles[] = 'ROLE_ADMIN';
                    
                    if ($io->confirm('Is the user super administrator ?', false)) {
                        $roles[] = 'ROLE_SUPER_ADMIN';
                    }
                }
            } else {
                $roles = $user->getRoles();

                foreach ($roles as $key => $role) {
                    if ($role === 'ROLE_USER') {
                        unset($roles[$key]);
                    }
                }
            }

            $user->setUsername($username !== null ? $username : $user->getUsername())
                ->setRoles($roles)
                ->setFirstName($firstName !== null ? $firstName : $user->getFirstName())
                ->setLastName($lastName !== null ? $lastName : $user->getLastName());

            $this->userService->update($user);

            if ($resetPassword) {
                $this->userService->resetPassword($user);
            }
    
            $io->success('The user was successfully updated !');
        } else {
            $io->error('Can\'t find user with username \'' . $username . '\'');
        }

        return Command::SUCCESS;
    }
}
