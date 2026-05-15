<?php

namespace App\Console\Commands;

use App\Documents\Tasks;
use Doctrine\ODM\MongoDB\DocumentManager;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:check-task-sla')]
#[Description('Command description')]
class CheckTaskSla extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(DocumentManager $dm): void
    {
        $now = new \DateTime();

        $tasks = $dm
            ->createQueryBuilder(Tasks::class)
            ->field('is_sla_breached')->equals(false)
            ->field('execution_status')->notIn(['completed', 'cancelled','closed', 'rejected'])
            ->field('due_at')->exists(true)
            ->field('due_at')->lte($now)
            ->getQuery()
            ->execute();

        foreach ($tasks as $task) {

            if (
                $task->getDueAt()
                && $now > $task->getDueAt()
            ) {

                $task->setIsSlaBreached(true);

                $task->setSlaBreachCount(
                    $task->getSlaBreachCount() + 1
                );
            }
        }

        $dm->flush();
    }
}
