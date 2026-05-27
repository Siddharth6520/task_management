import HeroImg from "../assets/images/hero_page.jpg"
import Card from "../components/Card";
const HeroSection = () => {
    return (
        <div>
            <section className="container mx-auto px-10 py-20">
                <div className="grid lg:grid-cols-2 items-center gap-16">

                    <div>
                        <span className="bg-indigo-50 text-indigo-600 px-4 py-2 rounded-full">
                            Productivity made simple
                        </span>

                        <h1 className="text-5xl font-bold text-slate-900 mt-6 leading-tight">
                            Simplify your workflow.
                            <span className="text-indigo-600">
                                {" "}Master your day.
                            </span>
                        </h1>

                        <p className="mt-6 text-slate-600 text-lg">
                            The intuitive task management interface designed
                            to eliminate clutter, organize priorities,
                            and boost collaboration.
                        </p>
{/* 
                        <div className="flex gap-4 mt-8">
                            <Button title="Get Started" />
                            <Button title="Learn More" />
                        </div> */}
                    </div>

                    <div>
                        <img src={HeroImg} />
                    </div>

                </div>
            </section>

            <section id="features">
                <Card />
            </section>
        </div>
    )
}

export default HeroSection;