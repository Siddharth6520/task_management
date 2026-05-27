const Card = () => {

    const features = [
        {
            name: "Intuitive Task Overview",
            description: "Easily track tasks, deadlines, and progress with a clean, structured layout that enhances productivity."
        },
        {
            name: "Drag & Drop Your Task",
            description: "Seamlessly organize tasks with a simple drag-and-drop interface, making workflow adjustments effortless."
        },
        {
            name: "Real-Time Collaboration",
            description: "Assign tasks, leave comments, and get instant updates to keep your team aligned and on track."
        },
        {
            name: "Customizable Dashboard",
            description: "Personalize your workspace with widgets for task lists, progress charts, and notifications for a tailored experience."
        },
        {
            name: "Dark & Light Mode",
            description: "Switch between dark and light themes for a visually comfortable and user-friendly interface anytime, anywhere."
        },
        {
            name: "Seamless Integrations",
            description: "Connect with third-party tools like Slack, Trello, and Google Calendar for a smooth and efficient workflow."
        }
    ];

    return (
        <div>
           <h1 className="text-4xl text-center pb-4 font-medium">Features</h1>
        <div className="grid grid-cols-3 gap-6 m-5 w-auto ">
         
            {features.map((feature, index) => (
                <div className=" p-10 border-0 rounded-2xl backdrop-blur-lg shadow-xl
                transition-all duration-300 hover:translate-y-1
                hover:shadow-2xl" key={index}>
                    <h3 className="font-bold pb-2 text-xl text-black">{feature.name}</h3>
                    <p>{feature.description}</p>
                </div>
            ))}
        </div>
        </div>
    );
};

export default Card;