import apache_log_parser  # https://github.com/rory/apache-log-parser
import os
from matplotlib.colors import Normalize

import matplotlib.pyplot as plt
import matplotlib
import numpy as np
import matplotlib.dates as mdates
from collections import Counter
import datetime

from matplotlib.backends.backend_pdf import PdfPages


try:
    # uname=input("Enter username for clamv = ")
    uname = "nacharya"
    # to hide the password while user is inputing
    # check the man page
    st1 = " scp " + uname + "@10.72.1.14:/../../var/log/apache2/access_log ./"
    os.system(st1)
except Exception:
    exit()

# get log files in the same directory as that of the script file


file = open("access_log", "r")


errors = []
# parse function
line_parser = apache_log_parser.make_parser(
    '%h %l %u %t "%r" %s %b "%{Referer}i" "%{User-Agent}i"'
)
data = []
for line in file:
    # if our subdirectory and not including css/images links
    if line.find("~nacharya") != -1 and line.find("assets") == -1:
        try:
            log_line_data = line_parser(line)
        except:
            continue

        # add only errors
        if int(log_line_data["status"]) >= 400:
            errors.append(log_line_data)
        # add everything
        data.append(log_line_data)

file.close()

# short names for parsing
url = "request_url"
remotehost = "remote_host"
browser = "request_header_user_agent__browser__family"


urls = {}
browsers = {}  # count
ipcount = {}
error_urls = {}

paths = {}  # for tree
for d in data:  # go through each parsed data

    # for counting
    if d[url] in urls:  # if url is already there
        urls[d[url]].append(d)
    else:
        urls[d[url]] = [d]

    if (d[browser]) in browsers:
        browsers[d[browser]] += 1
    else:
        browsers[d[browser]] = 1

    if (d[remotehost]) in ipcount:
        ipcount[d[remotehost]] += 1
    else:
        ipcount[d[remotehost]] = 1

    if int(d["status"]) >= 400:
        # for counting
        if d[url] in error_urls:  # if url is already there
            error_urls[d[url]].append(d)
        else:
            error_urls[d[url]] = [d]

    # all this code whill show tree of
    # url -> ip -> browser -> time

    if d[url] in paths:  # if url is already there
        if d[remotehost] in paths[d[url]]:  # if remote ip is there
            if (
                d[browser] in paths[d[url]][d[remotehost]]
            ):  # if same browser with same url
                paths[d[url]][d[remotehost]][d[browser]]["time"].append(
                    d["time_received_isoformat"]
                )
                # if browser exist add browser count
                paths[d[url]][d[remotehost]][d[browser]]["count"] += 1
            else:  # if no browser add time and count for browser
                paths[d[url]][d[remotehost]][d[browser]] = {
                    "count": 1,
                    "time": [(d["time_received_isoformat"])],
                }
            paths[d[url]][d[remotehost]]["count"] += 1  # adding ip count
        else:  # if no ip add ip /browser/ time and count for ip and browser.
            paths[d[url]][d[remotehost]] = {
                "count": 1,
                d[browser]: {"count": 1, "time": [(d["time_received_isoformat"])]},
            }
        paths[d[url]]["count"] += 1  # //if url exists add count
    else:
        paths[d[url]] = {
            "count": 1,
            d[remotehost]: {
                "count": 1,
                d[browser]: {"count": 1, "time": [(d["time_received_isoformat"])]},
            },
        }


for url in paths:
    print("")
    print("============================================")

    print(url, end="")
    for remotehost in paths[url]:
        if remotehost == "count":
            print(" > Count:", paths[url]["count"])
        else:
            print("")

            print("---", remotehost, end="")
            for browser in paths[url][remotehost]:
                if browser == "count":
                    print(" > Count:", paths[url][remotehost]["count"])
                else:
                    print("   ---", browser, end="")
                    for url3 in paths[url][remotehost][browser]:
                        if url3 == "count":
                            print(" > Count:", paths[url][remotehost][browser]["count"])
                        elif url3 == "time":
                            for t in paths[url][remotehost][browser]["time"]:
                                print("       ------", t)


print("\n\n=============ERRORS============")

for error in errors:
    print(
        f"\n\nURL:  {error['request_url']} \nRequested By:  {error['remote_host']} \nError code: {error['status']} \nTime received:  {error['time_received_isoformat']}"
    )


print("\n\n=============ALL URLs============")

for key in urls:
    print(key, " ", len(urls[key]))

print("\n\n=============ALL BROWSERS ============")

for key in browsers:
    print(key, " ", browsers[key])


# diagrams

with PdfPages("Statistics_access_log.pdf") as pdf:

    # for url count
    plt.figure(figsize=(11, 13))
    # plot url
    x = [key for key in urls]
    y = [len(urls[key]) for key in urls]
    x_pos = [i for i, _ in enumerate(x)]
    plt.barh(
        x_pos,
        y,
        color="green",
    )
    plt.ylabel("Urls")
    plt.xlabel("Url Visits")
    plt.title("All URL Count")
    plt.yticks(x_pos, x)
    for i, v in enumerate(y):
        plt.text(v + 0.5, i, str(v), color="black", fontweight="bold")
    pdf.savefig(bbox_inches="tight")
    plt.close()

    for url in urls:  # for each url timeline
        times = {}

        plt.figure(figsize=(11, 9))

        for d in urls[url]:
            # print(d)

            if (d["time_received_datetimeobj"].strftime("%Y-%m-%d")) in times:
                times[d["time_received_datetimeobj"].strftime("%Y-%m-%d")].append(
                    d["remote_host"]
                    + "\n"
                    + d["request_header_user_agent__browser__family"]
                    + "\n"
                    + d["time_received_datetimeobj"].strftime("%H:%M:%S")
                )
            else:
                times[d["time_received_datetimeobj"].strftime("%Y-%m-%d")] = [
                    d["remote_host"]
                    + "\n"
                    + d["request_header_user_agent__browser__family"]
                    + "\n"
                    + d["time_received_datetimeobj"].strftime("%H:%M:%S")
                ]

        tups = []

        for key1 in times:
            for dt in times[key1]:
                tups.append((key1, dt))

        d1, names = zip(*tups)

        # print(tups)
        # names=[times[key] for key in times]

        # Convert date strings (e.g. 2014-10-18) to datetime
        dates = [datetime.datetime.strptime(key, "%Y-%m-%d") for key in d1]

        # Choose some nice levels
        levels = np.tile(
            [16, 15, 14, 13, 12, 11, 10, 9, 8, 7, 6, 5, 4, 3, 2, 1],
            int(np.ceil(len(dates) / 6)),
        )[: len(dates)]

        # Create figure and plot a stem plot with the date
        fig, ax = plt.subplots(figsize=(11, 9), constrained_layout=True)
        ax.set(title=url + " Count : " + str(len(urls[url])))

        markerline, stemline, baseline = ax.stem(
            dates, levels, linefmt="C3-", basefmt="k-", use_line_collection=True
        )

        plt.setp(markerline, mec="k", mfc="w", zorder=3)

        # Shift the markers to the baseline by replacing the y-data by zeros.
        markerline.set_ydata(np.zeros(len(dates)))

        # annotate lines
        vert = np.array(["top", "bottom"])[(levels > 0).astype(int)]
        for d, l, r, va in zip(dates, levels, names, vert):
            ax.annotate(
                r,
                xy=(d, l),
                xytext=(-3, np.sign(l) * 3),
                textcoords="offset points",
                va=va,
                ha="right",
                fontsize=7,
            )

        # format xaxis with 1 day intervals
        ax.get_xaxis().set_major_locator(mdates.DayLocator(interval=1))
        ax.get_xaxis().set_major_formatter(mdates.DateFormatter("%d %m %Y"))
        plt.setp(ax.get_xticklabels(), rotation=0, ha="right")

        # remove y axis and spines
        ax.get_yaxis().set_visible(False)
        for spine in ["left", "top", "right"]:
            ax.spines[spine].set_visible(False)

        ax.margins(y=0.1)
        # plt.show()

        pdf.savefig()
        plt.close("all")

        # for error_url count
    plt.figure(figsize=(11, 13))
    # plot url
    x = [key for key in error_urls]
    y = [len(error_urls[key]) for key in error_urls]
    x_pos = [i for i, _ in enumerate(x)]
    plt.barh(
        x_pos,
        y,
        color="green",
    )
    plt.ylabel("ERROR URLs")
    plt.xlabel(" Visits")
    plt.title("All ERROR URL Count")
    plt.yticks(x_pos, x)
    for i, v in enumerate(y):
        plt.text(v + 0.5, i, str(v), color="black", fontweight="bold")
    pdf.savefig(bbox_inches="tight")
    plt.close()

    for url in error_urls:  # for each url timeline
        times = {}

        plt.figure(figsize=(11, 9))

        for d in error_urls[url]:
            # print(d)

            if (d["time_received_datetimeobj"].strftime("%Y-%m-%d")) in times:
                times[d["time_received_datetimeobj"].strftime("%Y-%m-%d")].append(
                    d["remote_host"]
                    + "\n ERROR: "
                    + d["status"]
                    + "\n"
                    + d["time_received_datetimeobj"].strftime("%H:%M:%S")
                )
            else:
                times[d["time_received_datetimeobj"].strftime("%Y-%m-%d")] = [
                    d["remote_host"]
                    + "\n ERROR: "
                    + d["status"]
                    + "\n"
                    + d["time_received_datetimeobj"].strftime("%H:%M:%S")
                ]

        tups = []

        for key1 in times:
            for dt in times[key1]:
                tups.append((key1, dt))

        d1, names = zip(*tups)

        # print(tups)
        # names=[times[key] for key in times]

        # Convert date strings (e.g. 2014-10-18) to datetime
        dates = [datetime.datetime.strptime(key, "%Y-%m-%d") for key in d1]

        # Choose some nice levels
        levels = np.tile(
            [16, 15, 14, 13, 12, 11, 10, 9, 8, 7, 6, 5, 4, 3, 2, 1],
            int(np.ceil(len(dates) / 6)),
        )[: len(dates)]

        # Create figure and plot a stem plot with the date
        fig, ax = plt.subplots(figsize=(11, 9), constrained_layout=True)
        ax.set(title=url + " Count : " + str(len(error_urls[url])))

        markerline, stemline, baseline = ax.stem(
            dates, levels, linefmt="C3-", basefmt="k-", use_line_collection=True
        )

        plt.setp(markerline, mec="k", mfc="w", zorder=3)

        # Shift the markers to the baseline by replacing the y-data by zeros.
        markerline.set_ydata(np.zeros(len(dates)))

        # annotate lines
        vert = np.array(["top", "bottom"])[(levels > 0).astype(int)]
        for d, l, r, va in zip(dates, levels, names, vert):
            ax.annotate(
                r,
                xy=(d, l),
                xytext=(-3, np.sign(l) * 3),
                textcoords="offset points",
                va=va,
                ha="right",
                fontsize=7,
            )

        # format xaxis with 1 day intervals
        ax.get_xaxis().set_major_locator(mdates.DayLocator(interval=1))
        ax.get_xaxis().set_major_formatter(mdates.DateFormatter("%d %m %Y"))
        plt.setp(ax.get_xticklabels(), rotation=0, ha="right")

        # remove y axis and spines
        ax.get_yaxis().set_visible(False)
        for spine in ["left", "top", "right"]:
            ax.spines[spine].set_visible(False)

        ax.margins(y=0.1)
        # plt.show()

        pdf.savefig()
        plt.close("all")

    plt.figure(figsize=(11, 9))

    # plot browsers
    x = [key for key in browsers]
    y = [browsers[key] for key in browsers]

    explode = (0, 0, 0, 0)

    fig1, ax1 = plt.subplots()
    plt.title("Browser Division")

    ax1.pie(
        y,
        explode=explode,
        labels=x,
        autopct="%1.1f%%",
        shadow=False,
        startangle=90,
        normalize=False,
    )
    ax1.axis("equal")  # Equal aspect ratio ensures that pie is drawn as a circle.

    pdf.savefig()
    plt.close("all")

    # ipcount
    plt.figure(figsize=(11, 9))

    x = [key for key in ipcount]
    y = [ipcount[key] for key in ipcount]

    x_pos = [i for i, _ in enumerate(x)]

    plt.barh(
        x_pos,
        y,
        color="red",
    )
    plt.ylabel("IPs")
    plt.xlabel("IP Visits")
    plt.title("IP Count")
    plt.yticks(x_pos, x)
    for i, v in enumerate(y):
        plt.text(v + 0.5, i, str(v), color="black", fontweight="bold")
    pdf.savefig()
    plt.close("all")
