import axios from "axios";

const api = axios.create({
    baseURL: "http://localhost:9000/api"
});

let token = "";

async function login() {
    try {

        const response = await api.post("/login", {
            email: "admin@gmail.com",
            password: "admin123"
        });

        token = response.data.data.token;

        api.defaults.headers.common[
            "Authorization"
        ] = `Bearer ${token}`;

        console.log("✅ Logged in");

    } catch (error) {

        console.log(
            "❌ Login failed:",
            error.response?.data || error.message
        );

        process.exit();
    }
}

async function run() {

    await login();

    const endpoints = [
        "/users",
        "/projects",
        "/teams",
        "/tasks",
        "/workflow-templates",
        "/workflow-stages",
        "/role-permissions",
        "/task-status-history",
        "/task-extensions"
    ];

    let passed = 0;
    let failed = 0;

    console.log("\n===== API TEST STARTED =====\n");


    for (const endpoint of endpoints) {

        try {

            const response = await api.get(endpoint);

            if (
                response.status === 200 &&
                response.data.success === true
            ) {
                passed++;

                console.log(
                    `✅ ${endpoint} | Records: ${response.data.data?.length ?? 1
                    }`
                );
            } else {
                failed++;

                console.log(`❌ ${endpoint}`);
            }

            // const response = await api.get(endpoint);

            // if (response.status === 200) {

            //     passed++;

            //     console.log(
            //         `✅ ${endpoint}`
            //     );

            // } else {

            //     failed++;

            //     console.log(
            //         `❌ ${endpoint}`
            //     );
            // }

        } catch (error) {

            failed++;

            console.log(
                `❌ ${endpoint}`
            );

            console.log(
                `   Error: ${error.response?.data?.message ||
                error.message
                }`
            );
        }
    }

    console.log("\n===== SUMMARY =====");

    console.log(
        `Total APIs : ${endpoints.length}`
    );

    console.log(
        `Passed    : ${passed}`
    );

    console.log(
        `Failed    : ${failed}`
    );

    console.log(
        "\n===== TEST COMPLETED ====="
    );
}

run();