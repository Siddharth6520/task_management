import HeroImg from "../assets/images/hero_page.jpg"
import Card from "../components/Card";
const HeroSection = () => {
    return (
        <div>
            <section className="w-full  flex flex-row items-center m-3 p-4 gap-8 rounded-lg">

                <div>
                    <div className="inline-flex items-center gap-1.5 bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-semibold px-3 py-1 rounded-full mb-6">
                    </div>

                    <h1 className="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        Simplify your workflow.
                        <span className="text-indigo-600">
                            Master your day.
                        </span>
                    </h1>

                    <p className="mt-6 text-base sm:text-lg text-slate-600 leading-relaxed">
                        The intuitive task management interface designed to eliminate clutter, organize priorities, and boost team collaboration.
                    </p>
                </div>

                <div>
                    <img src={HeroImg} alt="Heroimage" className="w-125" />
                </div>

            </section>

            <section id="features">
                <Card />
            </section>
        </div>
    )
}

export default HeroSection;