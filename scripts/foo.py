import fileinput
import sys

print("python says hi!")

for i in sys.argv:
    print("hello " + str(i))
# for a in raw_input():
#     print("woah " + a)

sys.stdout.flush
sys.stdin.close
sys.stdout.close