import {
  FaTasks,
  FaUsers,
  FaChartLine,
  FaRocket,
  FaArrowRight
} from "react-icons/fa";

const workflows = [
  {
    title: "Plan Tasks",
    icon: <FaTasks size={30} />,
    steps: ["Create", "Set Priorities", "Add Deadlines"]
  },
  {
    title: "Collaborate",
    icon: <FaUsers size={30} />,
    steps: ["Assign Members", "Comment", "Share Updates"]

  },
  {
    title: "Track Progress",
    icon: <FaChartLine size={30} />,
    steps: ["In Progress", "Review", "Completed"]

  },
  // {
  //   title: "Deliver Faster",
  //   icon: <FaRocket size={30} />,
  //   steps: ["Finalize", "Approve", "Launch"]

  // }
];

function WorkflowCards() {
  return (
    <div>
      <h1 className="text-4xl text-center pb-4 font-medium mt-24 mb-12">WorkFlows</h1>
      <div className="grid grid-cols-1 lg:grid-cols-3 gap-6 m-5">
        {workflows.map((workflow, index) => (
          <div
            key={index}
            className="p-6 border rounded-lg text-center"
          >
            <div className="mb-3">
              {workflow.icon}
            </div>

            <div>
              <h3 className="font-bold text-2xl">
                {workflow.title}
              </h3>

              <div className="flex items-center gap-2 mt-3">
                {workflow.steps.map((step, index) => (
                  <div key={index} className="flex items-center gap-2">
                    <span>{step}</span>

                    {index !== workflow.steps.length - 1 && (
                      <span><FaArrowRight size={12} /></span>
                    )}
                  </div>
                ))}
              </div>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
}

export default WorkflowCards;