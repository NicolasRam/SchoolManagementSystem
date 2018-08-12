<?php
/**
 * Created by PhpStorm.
 * User: moulaye
 * Date: 24/07/18
 * Time: 16:50
 */

namespace Backup\DataFixtures;


use App\Entity\Admin;
use App\Entity\Author;
use App\Entity\Librarian;
use App\Entity\Member;
use App\Entity\MemberSubscription;
use App\Entity\MemberType;
use App\Entity\Subscription;
use App\Entity\SuperAdmin;
use App\Entity\User;
use DateInterval;
use DatePeriod;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class MemberFixtures extends Fixture implements OrderedFixtureInterface
{
    public const MEMBERS_REFERENCE = 'books';
    public const MEMBERS_COUNT_REFERENCE = 100;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder ) {

        $this->encoder = $encoder;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for( $i = 0; $i < self::MEMBERS_COUNT_REFERENCE; $i++ )
        {
            $startDate = new DateTime( '2018-06-06' );
            $todayDate = new DateTime('now');
            $interval = DateInterval::createFromDateString('1 day');
            $period = new DatePeriod($startDate, $interval, $todayDate);

            $memberTypes = $manager->getRepository(MemberType::class)->findAll();
            $subscriptions = $manager->getRepository(Subscription::class)->findAll();

            $fakerFactory = Factory::create('fr_FR');
        }

//        /**
//         * @var \DateTime $day
//         */
//        foreach ($period as $day) {
//            if( rand(0, 1) )
//            {
//                $memberUser = new Member();
//
//                $memberUser->setFirstName( $fakerFactory->firstName );
//                $memberUser->setLastName( $fakerFactory->lastName );
//                $memberUser->setEmail( $fakerFactory->email );
//                $memberUser->setMemberType( $memberTypes[rand(0, count($memberTypes) - 1)]);
//                $encoded = $this->encoder->encodePassword($memberUser, '123456789');
//                $memberUser->setPassword( $encoded );
//
//                $manager->persist($memberUser);
//
//                $subscription = $subscriptions[rand( 0, count($subscriptions) - 1 )];
//
//                $memberSubscription = new MemberSubscription();
//
//                $endDate = $day;
//                $endDate->modify( '+' . $subscription->getDuration() . ' day'  );
//
//                $memberSubscription->setMember( $memberUser );
//                $memberSubscription->setStart( $day );
//                $memberSubscription->setEnd( $endDate );
//
//                $manager->persist($memberSubscription);
//
//                $manager->flush();
//            }
//        }
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }
}