<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobAd>
 */
class JobAdFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $fake = fake();

        return [
            'name' => fake()->jobTitle(),
            'subcompany' => fake()->company(),
            'office' => fake()->country(),
            'department' => "{$fake->name()} Department",
            'recruiting_category' => "{$fake->name()} Recruiting Category",
            'employment_type' => fake()->randomElement(['full-time', 'internship', 'part-time', 'contract']),
            'seniority' => fake()->randomElement(['entry-level', 'mid-level', 'senior', 'lead', 'principal']),
            'schedule' => fake()->randomElement(['on-site', 'remote', 'hybrid']),
            'status' => fake()->randomElement(['pending', 'approved', 'rejected']),
            'years_of_experience' => '2-5',
            'keywords' => fake()->words(5),
            'occupation' => "{$fake->name()} Occupation",
            'occupation_category' => "{$fake->name()} Occupation Category",
            'job_descriptions' => [
                [
                    'name' => 'About the Role',
                    'value' => 'Join us on our mission to become a global champion in commerce advertising and performance marketing.<br><br>mrge, a leading Commerce Advertising platform, connects over 5,500 publishers, 55,000 advertisers, and 100 networks in 160+ countries. It combines the expertise of five market leaders: digidip, specializing in premium publishers; MaxBounty, focused on direct partnerships; shopping24, offering product recommendations; SourceKnowledge, a CPC platform; and Yieldkit, delivering high reach and performance. Backed by Waterland private equity, mrge employs over 160 professionals with offices in Hamburg, Berlin, Montreal, and Ottawa.<br><br>Our culture runs on trust, friendliness, and collegiality, fostering a positive work atmosphere.<br>Working with us is easy and fun – just ask our clients, who we help to reach their goals in an uncomplicated, reliable way.<br><br>In close cooperation with our partners, we provide advertising formats that offer genuine relevance for our users and, as a result, lead to higher sales.',
                ],
                [
                    'name' => 'Your Tasks:',
                    'value' => '<p>We are looking for a skilled Senior Data Engineer to join our team at mrge. In this role, you will collaborate with cross-functional teams to design and develop robust data pipelines that empower data-driven decision-making across the organization. You’ll have the opportunity to design, build, and maintain a cutting-edge data platform, ensuring data accuracy, consistency, and reliability. Working closely with data analysts, and backend developers, you will play a key role in fostering a data-driven culture and ensuring our infrastructure scales as we grow.</p><p> </p><p>Key Responsibilities:</p><ul><li><p>Contribute to building and maintaining data pipelines and the data platform.  </p></li><li><p>Manage data ingestion from various sources, optimizing for efficiency and reliability.  </p></li><li><p>Collaborate with data analysts on complex data transformations, implementing orchestration tools and quality checks.  </p></li><li><p>Oversee the operational aspects of the data platform, including performance tuning and capacity management.  </p></li><li><p>As part of the team, engage in continuous learning, reviewing, and adapting, while fostering a culture of shared ownership and decision-making. Build solutions that are effective now and adaptable for the future.  </p></li><li><p>Mentor and guide junior team members, promoting best practices in data engineering.</p></li></ul>',
                ],
                [
                    'name' => 'Your Profile:',
                    'value' => '<h3><br></h3><ul><li><p>Proven experience with large-scale distributed data workloads </p></li><li><p>Advanced SQL and OLAP skills, with experience developing data pipelines and models, and working with data at scale.</p></li><li><p>Familiarity with Docker, Kubernetes (EKS) usage and management.</p></li><li><p>Excellent communication skills; values teamwork and believes a team is more than the sum of its parts. Enjoys mentoring and sharing knowledge with others.  </p></li><li><p>Autonomous, proactive, and customer-oriented mindset with a strong sense of ownership over projects.  </p></li><li><p>Proven Experience with Analytical Engineering and Data modelling</p></li><li><p>Proven experience with data governance, quality, and compliance practices. </p></li></ul><p><span style="font-size:24px;">Nice to have</span><br><br></p><ul><li><p>Experience with other programming languages like Java or Scala.</p></li><li><p>Experience with streaming and pub sub technologies</p></li><li><p>Previous experience in deploying and running ML models. </p></li><li><p>Expertise in both real time and batch data processing, and building pipelines  for analytical and ML use cases. </p></li></ul><p><span style="font-size:24px;">Our Preferred Tech Stack</span></p><p>Strong knowledge of Python and SQL. </p><ul><li><p>Modern data stack tool  Airbyte/Fivetran, Dagster and dbt for building pipelines.</p></li><li><p>Extensive experience with AWS is strongly preferred, but we are ready to consider candidates with strong knowledge of other cloud platforms. </p></li><li><p>OLAP systems like Clickhouse, Snowflake, Redshift or Databricks.</p></li><li><p>Streaming technologies like Kafka, Kinesis</p></li><li><p>IaC tools like Terraform</p></li></ul><p><span style="font-size:24px;">Nice to have</span></p><ul><li><p>Experience with other programming languages like Java or Scala.</p></li><li><p>Familiarity with Hadoop or Spark frameworks is a plus. </p></li><li><p>Container management tools like Kubernetes. </p></li><li><p>Experience with CI/CD tools like Terraform, GitHub Actions, and ArgoCD.</p></li></ul>',
                ],
                [
                    'name' => 'Your Oppurtunity:',
                    'value' => '<ul><li>Take an active role in shaping an innovative, growth-orientated international corporate group from its early stages; seize the opportunity to become irreplaceable!</li><li>Take on responsibility as you become an important part of a young, ambitious, and friendly team with a shared desire to develop its skills.</li><li>Enjoy opportunities to work independently, with flexible hours and hybrid remote/office working options.</li><li>Enjoy top-notch employee benefits: 30 paid vacation days, the latest tech, individual development plan, prepaid spending card (50€ monthly budget) and much more</li><li>Take your skills, talents, and career to the next level as you grow with us.</li></ul><strong>Have we convinced you? Then we can’t wait to read your application!</strong><br> <br>All our employees have equal career opportunities at mrge, regardless of gender, origin, ethnicity, religion, sexual orientation, age, or other personal attributes.<br>Candidates will be considered and selected equally based on their skills, qualification, and the needs of the company.<br>We know that experience and skills are matters of development and gain while working.<br>Therefore, we encourage you to apply even if your profile does not meet 100% of the requirements for this position.',
                ],
            ],
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function owner(User $owner)
    {
        return $this->state(fn () => [
            'created_by_id' => $owner->id,
            'updated_by_id' => $owner->id,
        ]);
    }

    public function status(string $status)
    {
        return $this->state(fn () => [
            'status' => $status,
        ]);
    }
}
